/**
 * sh404SEF - SEO extension for Joomla!
 *
 * @author      Yannick Gaultier
 * @copyright   (c) Yannick Gaultier 2012
 * @package     sh404sef
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     4.1.0.1559
 * @date    2013-04-25
 */

var shQuickControlNeedsUpdate = false;
var shAnalyticsCompletedRequestsList = {};
var shAnalyticsProgress = null;
var shAnalyticsOptions = null;

function shSetupQuickControl() {
  var url = "index.php?option=com_sh404sef&c=configuration&view=configuration&layout=qcontrol&format=raw&tmpl=component&noMsg=1";

  var onSuccess = function(response) {
    progress.empty();
    jQuery('#qcontrolcontent').html(response);
    shlBootstrap.updateBootstrap();
  };
  // request quick control panel
  var onFailure = function() {
    shUpdateQuickControl('<div class="alert alert-error">Server not responding for Quick control</div>');
  }

  jQuery.get(url, shUpdateQuickControl).fail(onFailure);

}

function shUpdateQuickControl(response) {

  jQuery('#qcontrolcontent').html(response);
  shlBootstrap.updateBootstrap();

}

function shSetupSecStats(task) {
  task = task || 'showsecstats';
  var url = "index.php?option=com_sh404sef&task=" + task + "&layout=secstats&format=raw&tmpl=component&noMsg=1";
  var progress = jQuery("#sh-progress-cpprogress").empty();
  progress.html("<div class='sh-ajax-loading'>&nbsp;</div>");

  // request quick control panel
  var onSuccess = function(response) {
    progress.empty();
    jQuery('#secstatscontent').html(response);
  };
  var onFailure = function() {
    progress.empty();
    shUpdateSecStats('<div class="alert alert-error">Server not responding for security stats</div>');
  };

  jQuery.get(url, onSuccess).fail(onFailure);

}

function shSetupUpdates(forced) {
  forced = forced ? "forced=1" : 'forced=0';
  var url = "index.php?option=com_sh404sef&task=showupdates&layout=updates&format=raw&tmpl=component&noMsg=1&" + forced;
  var progress = jQuery("#sh-progress-cpprogress").empty();
  progress.html("<div class='sh-ajax-loading'>&nbsp;</div>");
  var onSuccess = function(response) {
    progress.empty();
    jQuery('#updatescontent').html(response);
  };
  var onFailure = function() {
    progress.empty();
    shUpdateUpdates('<div class="alert alert-error">Server not responding for Updates check</div>');
  };

  jQuery.get(url, onSuccess).fail(onFailure);
}

function shAnalyticsRequestCompleted(req) {

  shAnalyticsCompletedRequestsList[req] = true;
  completed = true;
  jQuery.each(shAnalyticsCompletedRequestsList, function(key, value) {
    completed = completed && value;
  });
  if (completed) {
    shAnalyticsProgress.empty();
    setTimeout('shlBootstrap.updateBootstrap();', 250);
  }

}

function shSetupAnalytics(options) {

  shAnalyticsOptions = options || {};

  shAnalyticsProgress = jQuery("#sh-progress-analyticsprogress");
  shAnalyticsProgress.html("<div class='sh-ajax-loading'>&nbsp;</div>");

  var defaultOptions = {
    forced : 0,
    showFilters : 'yes',
    accountId : '',
    groupBy : '',
    startDate : '',
    endDate : '',
    cpWidth : 0,
    report : 'dashboard',
    subrequest : 'visits'
  };
  shAnalyticsOptions.showFilters = shAnalyticsOptions.showFilters ? shAnalyticsOptions.showFilters : defaultOptions.showFilters;
  forced = "forced=" + (shAnalyticsOptions.forced ? shAnalyticsOptions.forced : defaultOptions.forced);
  showFilters = "&showFilters=" + shAnalyticsOptions.showFilters;

  accountId = defaultOptions.accountId;
  var startDateEl = jQuery('#startDate');
  startDate = startDateEl && startDateEl.val() ? "&startDate=" + startDateEl.val() : defaultOptions.startDate;
  var endDateEl = jQuery('#endDate');
  endDate = endDateEl && endDateEl.val() ? "&endDate=" + endDateEl.val() : defaultOptions.endDate;
  var reportEl = jQuery('#report');
  report = "&report=" + (reportEl && reportEl.val() ? reportEl.val() : defaultOptions.report);
  var groupByEl = jQuery('#groupBy');
  groupBy = "&groupBy=" + (groupByEl && groupByEl.val() ? groupByEl.val() : defaultOptions.groupBy);
  var cpEl = jQuery('#sh404sef-analytics-wrapper');
  cpWidth = "&cpWidth=" + (cpEl ? cpEl.width() : defaultOptions.cpWidth);
  shAnalyticsOptions.url = "index.php?option=com_sh404sef&view=analytics&format=raw&tmpl=component&noMsg=1&" + forced
      + showFilters + report + accountId + groupBy + cpWidth + startDate + endDate;

  if (shAnalyticsOptions.showFilters == 'yes') {
    shAnalyticsCompletedRequestsList = {
      headers : false,
      visits : false,
      sources : false,
      global : false,
      perf : false,
      topsocialfb : false,
      topsocialtweeter : false,
      topsocialpinterest : false,
      topsocialplusone : false,
      topsocialplusonepage : false,
      top5urls : false,
      top5referrers : false
    };
  } else {
    shAnalyticsCompletedRequestsList = {
      headers : false,
      visits : false,
    };
  }

  // don't empty headers!
  jQuery.each(shAnalyticsCompletedRequestsList, function(key, value) {
    if (key != "headers") {
      try {
        jQuery("#analyticscontent_" + key).empty();
      } catch (e) {
        // alert(key);
      }
    }
  });

  _shPerformAnalyticsSubRequest('headers');
  _shPerformAnalyticsSubRequest('visits');

  if (shAnalyticsOptions.showFilters == 'yes') {
    for ( var i = 1; i < 11; i++) {
      setTimeout('shContinueAnalytics' + i + '();', 600 * i);
    }
  }
}

function shContinueAnalytics1() {

  _shPerformAnalyticsSubRequest('sources');

}

function shContinueAnalytics2() {

  _shPerformAnalyticsSubRequest('global');
}

function shContinueAnalytics3() {

  _shPerformAnalyticsSubRequest('perf');

}

function shContinueAnalytics4() {

  _shPerformAnalyticsSubRequest('top5urls');

}

function shContinueAnalytics5() {

  _shPerformAnalyticsSubRequest('top5referrers');
}

function shContinueAnalytics6() {

  _shPerformAnalyticsSubRequest('topsocialfb');
}
function shContinueAnalytics7() {

  _shPerformAnalyticsSubRequest('topsocialtweeter');
}
function shContinueAnalytics8() {

  _shPerformAnalyticsSubRequest('topsocialpinterest');
}
function shContinueAnalytics9() {

  _shPerformAnalyticsSubRequest('topsocialplusone');
}
function shContinueAnalytics10() {

  _shPerformAnalyticsSubRequest('topsocialplusonepage');
}

function _shPerformAnalyticsSubRequest(subrequestname) {

  var onSuccess = function(response) {
    shAnalyticsRequestCompleted(subrequestname);
    shUpdateAnalytics(response, subrequestname);
  };
  var onFailure = function() {
    shAnalyticsRequestCompleted(subrequestname);
    shUpdateAnalytics('<div class="alert alert-error">Server not responding for ' + subrequestname, subrequestname + '</div>');
  };

  jQuery.get(shAnalyticsOptions.url + '&subrequest=' + subrequestname, onSuccess).fail(onFailure);

}

function shUpdateAnalytics(response, subrequest) {

  jQuery('#analyticscontent_' + subrequest).html(response);
  id = jQuery('#startDate');

  if (id.length) {
    Calendar.setup({
      inputField : "startDate", // id of the input field
      ifFormat : "%Y-%m-%d", // format of the input field
      button : "startDate_img", // trigger for the calendar (button ID)
      align : "Bl", // alignment (defaults to "Bl")
      singleClick : true
    });
    Calendar.setup({
      inputField : "endDate", // id of the input field
      ifFormat : "%Y-%m-%d", // format of the input field
      button : "endDate_img", // trigger for the calendar (button ID)
      align : "Tl", // alignment (defaults to "Bl")
      singleClick : true
    });
  }
  setTimeout("jQuery('#sh-message-box').empty()", 3000);
  setTimeout("jQuery('#sh-error-box').empty()", 5000);
}

function shSubmitQuickControl() {

  var form = jQuery('#adminForm');

  // Create a progress indicator
  var update = jQuery("#sh-progress-cpprogress").empty();
  update.html("<div class='sh-ajax-loading'>&nbsp;</div>");

  // Set the options of the form"s Request handler.
  var onSuccessFn = function(response) {
    // alert(response);
    // remove progress indicator
    var update = jQuery("#sh-progress-cpprogress").empty();

    // insert results
    shUpdateQuickControl(response);

  };
  // request quick control panel
  var onFailure = function() {
    shUpdateQuickControl('<div class="alert alert-error">Server not responding for Quick control</div>');
  }
  jQuery('#sh404sef-qcontrol .alert').remove();
  jQuery.post('index.php', form.serialize(), onSuccessFn).fail(onFailure);
}
