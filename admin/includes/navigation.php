<nav class="navbar navbar-default navbar-fixed-top">
   	<div class="container">
   		<a href="/ecommerce website/admin/index.php" class="navbar-brand">VDZ Webshop Admin</a>
   		<ul class="navbar-nav nav">

         <li><a href="index.php">Dashboard</a></li>
         <li><a href="brands.php">Brands</a></li>
         <li><a href="categories.php">Categories</a></li>
         <li><a href="products.php">Products</a></li>
         <li><a href="deleted.php">Deleted Products</a></li>
         <?php if(has_permission('admin')): ?>
         <li><a href="users.php">Users</a></li>
         <?php endif; ?>

         <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hallo <?php echo $user_data['first']; ?>!
               <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
               <li><a href="change_password.php">Change Password</a></li>
               <li><a href="logout.php">Log Out</a></li>
            </ul>
         </li>

         <!--this is menu -->
<!--   			<li class="dropdown">
   				<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
   				<ul class="dropdown-menu" role="menu">

   					<li><a href="#"></a></li>

   				</ul>
   			</li> -->

   		</ul>
   	</div>
   </nav>
   <br><br><br><br>
