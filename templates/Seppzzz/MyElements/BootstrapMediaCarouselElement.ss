<!--THIS IS BOOTSTRAP_MEDIA_CAROUSEL_ELEMENT-->

<% require css(seppzzz/myelements: css/slider.css) %>
<% require javascript(seppzzz/myelements: javascript/slider.js) %>
		
	

	<!--start carousel-container-->
	<div class="carousel-container">  
	
		<div id="carousel_{$ID}" class="carousel  <% if $Fade %>carousel-fade<% else %> slide <% end_if %> w-100 rounded" data-ride="carousel" data-interval="<% if $SliderInterval %>$MySliderInterval()<% else %>false<% end_if %>" stop-on-hover="1" data-transition="$Transition"  style="transition-duration: {$Transition}s; background-color: lightgray;">
							
							
			<% if $Indicators %>
				<ol class="carousel-indicators">
					<% if $CarouselImages.Count() > 1 && $CarouselImages.Count() < 10 %>
						<% loop $CarouselImages.Filter('Display', '1').Sort(SortOrder) %>

								<li data-target="__HASHPH__carousel_{$Top.ID}" data-slide-to="{$Pos(0)}" class="<% if first %> active <% end_if %>"></li>

						<% end_loop %>
					<% end_if %>
				</ol>
			<% end_if %>
							
							
							
			<div class="carousel-inner w-100 rounded">			
									
				<% loop $MediaDataObjects.Sort(SortOrder) %>
					<% if $getSingularName() == MediaImage  %>	
						
						<div class="carousel-item  img-fluid w-100 rounded <% if $First %>	active <% end_if %>	<% if $Top.Fade %> d-block <% end_if %> " style="transition-duration: {$Top.Transition}s;">	
							
							
							<% if $Top.FullSize %>
								<img class=" img-fluidx <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.ScaleWidth(2400).CropHeight(600).URL" alt="$Image.Title">	
							<% else %>

								<% if $Up.Up.Crop != '0' %>
									<img class=" img-fluid <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.ScaleWidth(1200).CropHeight($Top.getCroppedHeight($Up.Up.Crop)).URL" alt="$Image.Title">
								<% else %>
									<img class=" img-fluid <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.CropHeight(1200).URL" alt="$Image.Title">
								<% end_if %>


							<% end_if %>
									
								
							<div class="carousel-caption d-none d-md-blockx">
								<h3 class="carousel-elementx captionx">$Caption Blabla</h3>
								<p>Some representative placeholder content for the $Top.addOrdinalSuffix($Pos).RAW slide.</p>
							</div>
							
							
						</div>			
										
					<% else_if $getSingularName() == MediaVideo  %>
						
						<div class="carousel-item  img-fluid w-100 rounded <% if $First %>	active <% end_if %>	<% if $Top.Fade %> d-block <% end_if %> " style="transition-duration: {$Top.Transition}s;">			
							
							
							<iframe width="600" height="413" src="https://www.youtube.com/embed/9QdYW0IjrEk?feature=oembed" frameborder="0" allow="accelerometer; autoplay=1; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen="" title="Baila Nova - A Felicidade (Antônio Carlos Jobim &amp; Moraes)"></iframe>
							
							
							<div class="carousel-caption d-none d-md-blockx">
								<h3 class="carousel-elementx captionx">$Caption Blabla</h3>
								<p>Some representative placeholder content for the $Top.addOrdinalSuffix($Pos).RAW slide.</p>
							</div>
							
							
						</div>	
										
					<% end_if %>
									
				<% end_loop %>
					
			</div>
							
			<a class="carousel-control-prev control-prev" href="__HASHPH__carousel_{$ID}" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon hide-prev" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
			</a>


			<a class="carousel-control-next control-next" href="__HASHPH__carousel_{$ID}" role="button" data-slide="next">
			<span class="carousel-control-next-icon hide-next" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
			</a>


	</div>
					
	<div class="d-flex justify-content-between align-items-end">

		<div class="newCaptionContainer w-100x mt-3 mr-5">xxx</div>
		<div class="crsl_slide-counter w-100x text-right mt-3"></div>	

	</div>
				
							
				
									

							
							
</div>	
<!--end carousel-container-->

		
   
<!-- BOOTSTRAP_CAROUSEL_ELEMENT END -->
							
							
							
							<%--
									<% if $Top.FullSize %>
										<img class=" img-fluidx <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.ScaleWidth(2400).CropHeight(600).URL" alt="$Image.Title">
									<% else %>
										
										
										<% if $Top.Crop != '0' %>
											<img class=" img-fluid <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.ScaleWidth(1200).CropHeight($Top.getCroppedHeight($Top.Crop)).URL" alt="$Image.Title">
											
										<% else %>
											<img class=" img-fluid <% if $Up.Up.Fade %> d-block <% end_if %> w-100 rounded " src="$Image.CropHeight(1200).URL" alt="$Image.Title">
										<% end_if %>
										
											
									<% end_if %>
									
									 <div class="carousel-caption d-none d-md-blockx">
        								<h3 class="carousel-elementx captionx">$Caption Blabla</h3>
        								<p>Some representative placeholder content for the $Top.addOrdinalSuffix($Pos).RAW slide.</p>
     								 </div>
										
							--%>
									
									
									
							
							
					
							
							
