<?php

$model = JRequest::getVar('special_model');
$formLayout = '<div style="padding:10px;background:url(/templates/gazebos/images/bg_darkpattern.png) repeat 0 0 scroll transparent;">
	<div class="quote-wrap">
		<img src="/templates/gazebos/images/quote_logo.png">
		<div style="padding:0 20px">
			<h3>GET A SHIPPING QUOTE</h3>
			<div id="quick-quote-widget">
				<div class="widget-wrap">
					<p>'. $model .'</p>
					<p>Please fill out the form below and a Gazebos.com consultant will contact you.</p>
{error}
<!-- Do not remove this ID, it is used to identify the page so that the pagination script can work correctly -->
<ul class="formContainer" id="custom-quote">
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="firstname" name="form[firstname]" size="20" placeholder="First Name"></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="lastname" name="form[lastname]" size="20" placeholder="Last Name"></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="email" name="form[email]" size="20" placeholder="Email *"><span class="formClr"><span class="formNoError" id="component51">Invalid Input</span></span></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="phonenum" name="form[phonenum]" size="20" placeholder="Phone" ></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="address" name="form[address]" size="20" placeholder="Address" ></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="city" name="form[city]" size="20" placeholder="City" ></div>
	</li>
	<li class="half">
		<div class="formBody"><select style="z-index:9999;" class="rsform-select-box chosen" id="state" name="form[state][]"><option value="State" selected="selected">State</option><option value="Alabama">Alabama</option><option value="Alaska">Alaska</option><option value="Arizona">Arizona</option><option value="Arkansas">Arkansas</option><option value="California">California</option><option value="Colorado">Colorado</option><option value="Connecticut">Connecticut</option><option value="Delaware">Delaware</option><option value="District Of Columbia">District Of Columbia</option><option value="Florida">Florida</option><option value="Georgia">Georgia</option><option value="Hawaii">Hawaii</option><option value="Idaho">Idaho</option><option value="Illinois">Illinois</option><option value="Indiana">Indiana</option><option value="Iowa">Iowa</option><option value="Kansas">Kansas</option><option value="Kentucky">Kentucky</option><option value="Louisiana">Louisiana</option><option value="Maine">Maine</option><option value="Maryland">Maryland</option><option value="Massachusetts">Massachusetts</option><option value="Michigan">Michigan</option><option value="Minnesota">Minnesota</option><option value="Mississippi">Mississippi</option><option value="Missouri">Missouri</option><option value="Montana">Montana</option><option value="Nebraska">Nebraska</option><option value="Nevada">Nevada</option><option value="New Hampshire">New Hampshire</option><option value="New Jersey">New Jersey</option><option value="New Mexico">New Mexico</option><option value="New York">New York</option><option value="North Carolina">North Carolina</option><option value="North Dakota">North Dakota</option><option value="Ohio">Ohio</option><option value="Oklahoma">Oklahoma</option><option value="Oregon">Oregon</option><option value="Pennsylvania">Pennsylvania</option><option value="Rhode Island">Rhode Island</option><option value="South Carolina">South Carolina</option><option value="South Dakota">South Dakota</option><option value="Tennessee">Tennessee</option><option value="Texas">Texas</option><option value="Utah">Utah</option><option value="Vermont">Vermont</option><option value="Virginia">Virginia</option><option value="Washington">Washington</option><option value="West Virginia">West Virginia</option><option value="Wisconsin">Wisconsin</option><option value="Wyoming">Wyoming</option></select></div>
	</li>
	<li class="half">
		<div class="formBody"><input type="text" class="rsform-input-box" id="zip" name="form[zip]" size="20" placeholder="Zip *" ><span class="formClr"><span class="formNoError" id="component54">Invalid Input</span></span></div>
	</li>
	<li class="full" style="clear:both;">
		<div class="formBody">{catalog:body}</div>
	</li>
	<li class="submit">
		<div class="formBody">{submit:body}<span class="formClr">{submit:validation}</span></div>

	</li>
</ul>
{special_model:body}

</div>
			</div>
		</div>
	</div>
</div>'