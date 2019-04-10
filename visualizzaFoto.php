<?php
if(!isset($_SESSION))
{
    session_start();
} ;

if (!isset($_SESSION["email"]) or !isset($_SESSION["password"])){
    header("location: index.php");
}

?>
<?php include_once('user.php');?>
<?php
$objectFoto = new User();
$res = $objectFoto -> visualizzaFoto($_SESSION['email']);
echo'
<!-- Testimonial Section -->
			<div class="testimonial-section">
				<!-- Container -->
				<div class="container">
					<div class="testi-img-block">
				<div class="testi-carousel owl-carousel">
';

while ($row=$res->fetch(PDO::FETCH_ASSOC)) {
    echo' 
							<div data-position="0">
								<a href="javascript:void(0);" data-test="1">
									<img src="'.$row['PATHFOTO'].'" alt="testimonial" />
								</a>
							</div>
						';
}
echo' </div>
   <div class="testi-nav">
							<div class="testi-prev"><i class="fa fa-angle-left"></i></div>
							<div class="testi-next"><i class="fa fa-angle-right"></i></div>
						</div>
					</div>
				</div><!-- Container /- -->
			</div><!-- Testimonial Section /- -->
';
?>