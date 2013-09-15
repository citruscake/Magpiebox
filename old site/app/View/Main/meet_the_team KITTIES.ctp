<script type="text/javascript">

function showPictureFrame(i,elem) {

	$(elem).animate({'left' : -35+(parseInt($(this).css("left")))}, {duration: (i+1)*400, easing:"easeInQuad", queue:false});

}

$(document).ready(function() {  

	var gallery_width = $(".image_gallery_container").css('width');
	//$(this).css("left", gallery_width+((parseInt($(this).css("width"))+35)*i));
	$(".image_inner_frame").each(function(i,elem) {
		switch(i) {
			case 0:
				$(this).css("top", 80);
				break;
			case 1:
				$(this).css("top", 45);
				break;		
			case 2:
				$(this).css("top", 85);
				break;
			case 3:
				$(this).css("top", 60);
				break;
			default:;
		}
	});
	
	//var gallery_width = $(".image_gallery_container").css('width');
	//console.log('hello');

	$("#image_gallery_container").animate({opacity:1}, {duration:300});
	
	$(".image_inner_frame").each(function(i,elem) {
	
		var gallery_width = $(".image_gallery_container").css('width');
	
		setTimeout(function() {
			$(elem).animate({'left' : -(1237-53) +(parseInt($(elem).css("left")))}, {duration: 1000, easing:"easeOutQuad", queue:false});
		}, 300+((i)*350));
		
		setTimeout(function() {
			$(elem).animate({'opacity' : 1}, {duration: 3000, easing:"easeOutQuad", queue:false});
		}, 2700);
		
		//showPictureFrame(elem);
		//$(this).animate({
		//'left' : -35+(parseInt($(this).css("left")))}, {duration: (i+1)*400, easing:"easeInQuad", queue:false});
		
		//$(this).delay((i+1)*1000).animate({
		//'opacity' : 1}, {duration: 600, easing:"easeInCirc", queue:true});
		
		});
});

</script>
<style type="text/css">

#image_gallery_container {

width: 1050px;
height: 480px;
background-color: #ffffff;
margin-top: 53px;
margin-left: -5px;
background-image: url('/img/wallpaper4.jpg');
background-width:100%;
position:relative;
opacity:0;
overflow: hidden;
border-style: solid;
border-width: 2px;
border-color: rgb(180, 180, 180);
}

#image_gallery {

	//margin-top:50px;
	//width:100%;
	//height:100%;
	position:relative;

}

.image_outer_frame {

	border-width:3px;
	border-color:#ffffff;
	border-style:solid;
	width:265px;
	text-align:center;
	height:350px;
	position:absolute;

}

.image_inner_frame {

width: 255px;
background-color: #222222;
height: 338px;
position: absolute;
opacity : 0.2;
//border-width:3px;
//border-color:#333333;
//border-style:solid;
//display: inline;
//float: left;
background-size:235px;
background-repeat:no-repeat;
background-position:center;
//margin-top: 35px;
//margin-left: 41px;
-webkit-box-shadow:  2px 2px 3px 2px rgba(1, 1, 1, 0.3);
        
        box-shadow:  2px 2px 3px 2px rgba(1, 1, 1, 0.3);
}

#image_frame_0 {
	left: 1237; //1237+(i*(35+255);
	top : 80;
	position:relative;
//	transform: rotate(1deg);
//-ms-transform: rotate(1deg); /* IE 9 */
//-webkit-transform: rotate(1deg); /* Safari and Chrome */
background-image:url('http://www.catsofaustralia.com/images/cute_baby_kitten.jpg');
}

#image_frame_1 {
	left: 1527;
	top: 45;
	position:relative;
//	transform: rotate(-1deg);
//-ms-transform: rotate(-1deg); /* IE 9 */
//-webkit-transform: rotate(-1deg); /* Safari and Chrome */
background-image:url('http://i4.cdnds.net/12/33/618x695/kitten.jpg');
}

#image_frame_2 {
	left: 1817;
	top: 85;
	position:relative;
	//transform: rotate(-1.5deg);
//-ms-transform: rotate(-1.5deg); /* IE 9 */
//-webkit-transform: rotate(-1.5deg); /* Safari and Chrome */
background-image:url('http://cdn.cutestpaw.com/wp-content/uploads/2012/04/l-my-first-kitten.jpg');
}

#image_frame_3 {
	left : 2107;
	top:60;
	position:relative;
//	transform: rotate(1deg);
//-ms-transform: rotate(1deg); /* IE 9 */
//-webkit-transform: rotate(1deg); /* Safari and Chrome */
background-image:url('http://www.jennings81.freeserve.co.uk/kit4%20(1).jpg');
}


</style>
<html>

	<div id="image_gallery_container">
		<div id="image_gallery">
			<div id="image_frame_0" class="image_inner_frame">
			</div>
			<div id="image_frame_1" class="image_inner_frame">
			</div>
			<div id="image_frame_2" class="image_inner_frame">
			</div>
			<div id="image_frame_3" class="image_inner_frame">
			</div>
		</div>
	</div>

</html>