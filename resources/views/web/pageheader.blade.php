<HEADER class="site-header" id="masthead">
				<DIV class="primary-header">
					<DIV class="container">
						<DIV class="primary-header-inner">
							<DIV class="site-branding">
								<h2 class="site-title">
									<a href="/" rel="home"><img src="src/logo.png" style="width: 12%; margin: 1%;"></a></h2>
								<H3 class="site-description">海外小厨房</H3></DIV>
							<DIV class="primary nav-menu">
								<DIV class="nav-menu-container">
									<UL class="menu" id="menu-menu">
										<LI class="menu-item menu-type-link menu-item-search">
											<A class="search-overlay-toggle" href="http://mealmir.com/register/#search-header" data-toggle="#search-header"></A>
										</LI>
										<LI class="menu-item menu-item-type-post_type_archive menu-item-object-job_listing menu-item-100" id="menu-item-100">
											<A href="/listings">Explore</A></LI>
										<LI class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140" id="menu-item-140">
											<A href="/about">About Us</A></LI>
										@if ($user_id == '')
										    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-129" id="menu-item-129">
												<a class="popup-trigger-ajax" href="/login">Log In</a>
											</li>
											<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-239" id="menu-item-239">
												<A href="/register
												@php 
												if (isset($_GET['url'])) {
													echo ('?url='.$_GET['url']);
												}
												@endphp">Register</A>
											</LI>
										@else
										   <LI class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-menu-ancestor current-menu-parent current-page-parent current_page_parent current_page_ancestor menu-item-has-children menu-item-125 account-avatar" id="menu-item-125">
												<A href="/myaccount?id={{$user_id}}">
													<DIV class="current-account-avatar" data-href="/myaccount?id={{$user_id}}">
														<IMG width="90" height="90" class="avatar avatar-90 wp-user-avatar wp-user-avatar-90 photo avatar-default" alt="" src="/uploads/{{$user_pic}}"></DIV>{{$user_name}}</A>
												<UL class="sub-menu">
													<LI class="ion-ios-speedometer-outline menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-page-parent menu-item-126" id="menu-item-126">
														<A href="/myaccount?id={{$user_id}}">Account</A></LI>
													
													<LI class="ion-ios-plus-outline menu-item menu-item-type-post_type menu-item-object-page menu-item-161" id="menu-item-161">
														<A href="/addact">Add Activity</A></LI>
													<LI class="ion-ios-compose-outline menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-163 current_page_item menu-item-166" id="menu-item-166">
														<A href="/actlist">Your Activity</A></LI>
													<LI class="ion-ios-list-outline menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-163 current_page_item menu-item-166" id="menu-item-166">
														<A href="/myodrlist">Your Order</A></LI>
													<LI class="ion-ios-list-outline menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-163 current_page_item menu-item-166" id="menu-item-166">
														<A href="/mysublist">Your subscription</A></LI>
													<LI class="ion-ios-gear-outline menu-item menu-item-type-custom menu-item-object-custom menu-item-127" id="menu-item-127">
														<A href="/editpro">Edit Profile</A></LI>
													<LI class="ion-ios-arrow-thin-right menu-item menu-item-type-custom menu-item-object-custom menu-item-128" id="menu-item-128">
														<A href="/logout">Log Out</A></LI>
												</UL>
											</LI>
										@endif
									</UL>
								</DIV>
							</DIV>
						</DIV>
						<DIV class="search-overlay" id="search-header">
							<DIV class="container">
								<form class="search-form" role="search" action="/listings" method="get">
									<LABEL>
										<SPAN class="screen-reader-text">Search for:</SPAN>
										<INPUT name="search_keywords" title="Search for:" class="search-field" type="search" placeholder="Search" value=""></LABEL>
									<BUTTON class="search-submit" type="submit"></BUTTON>
								</FORM>
								<A class="ion-close search-overlay-toggle" href="http://mealmir.com/register/#search-header" data-toggle="#search-header"></A>
							</DIV>
						</DIV>
					</DIV>
				</DIV>
				<NAV class="main-navigation&#10;&#9;&#9;" id="site-navigation">
					<DIV class="container">
						<A class="navigation-bar-toggle" href="http://mealmir.com/register/#">
							<I class="ion-navicon-round"></I>
							<SPAN class="mobile-nav-menu-label">Menu</SPAN></A>
						<DIV class="navigation-bar-wrapper">
							<DIV class="primary nav-menu">
								<UL class="primary nav-menu" id="menu-menu-1">
									<LI class="menu-item menu-type-link menu-item-search">
										<A class="search-overlay-toggle" href="http://mealmir.com/register/#search-header" data-toggle="#search-header"></A>
									</LI>
									<LI class="menu-item menu-item-type-post_type_archive menu-item-object-job_listing menu-item-100">
										<A href="/listings">Explore</A></LI>
									<LI class="menu-item menu-item-type-post_type menu-item-object-page menu-item-140">
										<A href="/about">About Us</A></LI>
									@if ($user_id == '')
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-129">
										<a class="popup-trigger-ajax" href="/login">Log In</a></li>
									<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-239">
										<A href="/register
										@php 
										if (isset($_GET['url'])) {
											echo ('?url='.$_GET['url']);
										}
										@endphp">Register</A>
									@else
									<LI class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children menu-item-125 account-avatar" id="menu-item-125">
											<A href="/myaccount?id={{$user_id}}">
												<DIV class="current-account-avatar" data-href="/myaccount?id={{$user_id}}">
													<IMG width="90" height="90" class="avatar avatar-90 wp-user-avatar wp-user-avatar-90 photo avatar-default" alt="" src="/uploads/{{$user_pic}}"></DIV>{{$user_name}}</A>
											<UL class="sub-menu">
												<LI class="ion-ios-speedometer-outline menu-item menu-item-type-post_type menu-item-object-page menu-item-126" id="menu-item-126">
													<A href="/myaccount?id={{$user_id}}">Account</A></LI>
												<LI class="ion-ios-compose-outline menu-item menu-item-type-post_type menu-item-object-page menu-item-166" id="menu-item-166">
													<A href="/addact">Add Activity</A></LI>
												<LI class="ion-ios-plus-outline menu-item menu-item-type-post_type menu-item-object-page menu-item-161" id="menu-item-161">
													<A href="/actlist">Your Activity</A></LI>
												<LI class="ion-ios-gear-outline menu-item menu-item-type-custom menu-item-object-custom menu-item-127" id="menu-item-127">
													<A href="/myodrlist">Your Order</A></LI>
												<LI class="ion-ios-list-outline menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-163 current_page_item menu-item-166" id="menu-item-166">
														<A href="/mysublist">Your subscription</A></LI>
													<LI class="ion-ios-gear-outline menu-item menu-item-type-custom menu-item-object-custom menu-item-127" id="menu-item-127">
														<A href="/editpro">Edit Profile</A></LI>
													<LI class="ion-ios-arrow-thin-right menu-item menu-item-type-custom menu-item-object-custom menu-item-128" id="menu-item-128">
														<A href="/logout">Log Out</A></LI>
											</UL>
										</LI>
									@endif
								</UL>
							</DIV>
						</DIV>
						<A class="ion-search search-overlay-toggle" href="http://mealmir.com/register/#search-navigation" data-toggle="#search-navigation"></A>
						<DIV class="search-overlay" id="search-navigation">
							<form class="search-form" role="search" action="/listings" method="get">
								<LABEL>
									<SPAN class="screen-reader-text">Search for:</SPAN>
									<INPUT name="search_keywords" title="Search for:" class="search-field" type="search" placeholder="Search" value=""></LABEL>
								<BUTTON class="search-submit" type="submit"></BUTTON>
							</FORM>
							<A class="ion-close search-overlay-toggle" href="http://mealmir.com/register/#search-navigation" data-toggle="#search-navigation"></A>
						</DIV>
					</DIV>
				</NAV>
				<!-- #site-navigation --></HEADER>