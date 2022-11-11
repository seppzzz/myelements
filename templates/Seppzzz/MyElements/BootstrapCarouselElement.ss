<!--THIS IS BOOTSTRAP_CAROUSEL_ELEMENT-->

<% require css(seppzzz/myelements: css/slider.css) %>
<% require javascript(seppzzz/myelements: javascript/slider.js) %>

	
	
	
				<div id="carousel_{$ID}" class="carousel  <% if $Fade %>carousel-fade<% else %> slide <% end_if %> w-100 rounded" data-ride="carousel" data-interval="<% if $SliderInterval %>$MySliderInterval()<% else %>false<% end_if %>" stop-on-hover="1" data-transition="$Transition"  style="transition-duration: {$Transition}s;">
							
							
						<% if $Indicators %>
							<ol class="carousel-indicators">
								<% if $CarouselImages.Count() > 1 && $CarouselImages.Count() < 10 %>
									<% loop $CarouselImages.Filter('Display', '1').Sort(SortOrder) %>
										
											<li data-target="#carousel_{$ID}" data-slide-to="{$Pos(0)}" class="<% if first %> active <% end_if %>"></li>
										
									<% end_loop %>
								<% end_if %>
							</ol>
						<% end_if %>
							
							
							
						<div class="carousel-inner w-100 rounded">

							<% loop $CarouselImages.Filter('Display', '1').Sort(SortOrder) %>
								
						
								
								<div class="carousel-item  img-fluid w-100 rounded <% if First %>	active <% end_if %>	<% if $Top.Fade %> d-block <% end_if %> " style="transition-duration: {$Top.Transition}s;">	
									
									
									<% if $Top.FullSize %>
										<img class=" img-fluidx <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.ScaleWidth(2400).CropHeight(600).URL" alt="$Image.Title">
									<% else %>
										 <img class=" img-fluid <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.CropHeight(1200).URL" alt="$Image.Title">
									<% end_if %>
									
									 <div class="carousel-caption d-none d-md-block">
        								<h3 class="carousel-element caption">$Caption</h3>
        								<%--<p>Some representative placeholder content for the $Pos() slide.</p>--%>
     								 </div>
									
								</div>				
								
								
							<% end_loop %>
					
						</div>
							
						<a class="carousel-control-prev control-prev" href="#carousel_{$ID}" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon hide-prev" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
						</a>
						<a class="carousel-control-next control-next" href="#carousel_{$ID}" role="button" data-slide="next">
						<span class="carousel-control-next-icon hide-next" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
						</a>
								
				</div>
					
					
					
				
							
				
									
				<%--$Top.StartRow('no-gutters align-items-startx ')
							
						$Top.StartCol('col-10 mt-3 pr-4 align-self-start')
							<div class="project-slider-title  w-100 d-inline">$Title</div>
							<div class="project-slider-info  w-100 d-inline ">$Descriptionx</div>
						$Top.EndCol()	
	
							
						$Top.StartCol('col-2 align-self-start text-right mt-2')
							<div class="crsl_slide-counter"></div>
						$Top.EndCol()
							
				$Top.EndRow()--%>
							
				<%--$Top.StartRow('no-gutters align-items-start mb-5')			
					$Top.StartCol('col-12 mt-0 pr-4 mt-n1')
							<div class="project-slider-additional-text">$AdditionalText</div>
							
					$Top.EndCol()		
				$Top.EndRow()--%>
							
							
			

		
   
<!-- BOOTSTRAP_CAROUSEL_ELEMENT END -->
									
									
									
							
							
					
							
							