<!--THIS IS PANIMAGEELEMENT START-->

<%--$getCroppedHeight($Crop)--%>
	
<% if $ShowTitle %>	
	<div class="panimage-element <% if $Style %> $StyleVariant<% end_if %>">
        <h2 class="content-element__title">$Title</h2> 
	</div>
<% end_if %>
	

<div class="w-100 d-flex img-container panimage ">
	
	<% if $FullSize %>
		<img src="$PanImage.ScaleWidth(1200).CropHeight(300).URL" class="image-fluid w-100">
	<% else %>
		<% if $Crop != '0' %>
			<img src="$PanImage.ScaleWidth(1200).CropHeight($getCroppedHeight($Crop)).URL" class="image-fluid w-100 rounded">
		<% else %>
			<img src="$PanImage.ScaleWidth(1200).URL" class="image-fluid w-100 rounded">
		<% end_if %>
	<% end_if %>
		
	<% if $IsOverlayText %>
		<div class="w-100 text-center overlay">
			<span>
				<% if $FullSize %>
					<h1 class="themecolorx text-shaddow">$ImageTitle</h1>
				<% else %>
					<h3 class="themecolorx">$ImageTitle</h3>
				<% end_if %>
			</span>
		</div>
	<% end_if %>
		
</div>
		
	<% if not $IsOverlayText %>
		<br><br>
		<div class="w-100 text-center text-underneath themecolor">$ImageTitle </div>
		<br>
	<% end_if %>


			
			



<!--THIS IS PANIMAGEELEMENT END-->
							
					
							
							
