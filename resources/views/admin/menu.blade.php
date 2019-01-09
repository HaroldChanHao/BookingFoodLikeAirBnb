		<!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">MEALMIR Admin</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {{$adminUser}} <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li><a href="/admin/user/edit_pwd"><i class="fa fa-gear fa-fw"></i> 修改密码</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="/admin/user/admin_logout"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="@php if(strpos($adminPath,'activity') !== false) echo'active'; @endphp">
                            <a href=""><i class="fa fa-table fa-fw"></i> 活动模块<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            		<li>
                                    <a href="/admin/activity/add_class">添加活动分类</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/class_list">活动分类列表</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/add_city">添加活动城市</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/city_list">活动城市列表</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/index?stas=0">待审核活动</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/index?stas=1">待结单活动</a>
                                </li>
                                <li>
                                    <a href="/admin/activity/index?stas=2">已结束活动</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@php if(strpos($adminPath,'order') !== false) echo'active'; @endphp">
                            <a href="order.html"><i class="fa fa-list fa-fw"></i> 订单模块<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/order/index?stas=0">进行中订单</a>
                                </li>
                                <li>
                                    <a href="/admin/order/index?stas=1">已结束订单</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@php if(strpos($adminPath,'comment') !== false) echo'active'; @endphp">
                            <a href="comment.html"><i class="fa fa-star fa-fw"></i> 评价模块<span class="fa arrow"></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/comment/index?stas=0">待审核评价</a>
                                </li>
                                <li>
                                    <a href="/admin/comment/index?stas=1">已通过评价</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@php if(strpos($adminPath,'news') !== false) echo'active'; @endphp">
                            <a href="news.html"><i class="fa fa-th fa-fw"></i> 新闻模块<span class="fa arrow"></a>
                            	<ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/news/add_news">添加新闻</a>
                                </li>
                                <li>
                                    <a href="/admin/news/index">所有新闻</a>
                                </li>
                                <li>
                                    <a href="/admin/news/about">关于我们</a>
                                </li>
                            </ul>
                        </li>
                        <li class="@php if(strpos($adminPath,'user') !== false) echo'active'; @endphp">
                            <a href="user.html"><i class="fa fa-user fa-fw"></i> 用户模块<span class="fa arrow"></a>
                        		<ul class="nav nav-second-level">
                                <li>
                                    <a href="/admin/user/index">所有用户</a>
                                </li>
                                <li>
                                    <a href="/admin/user/edit_pwd">修改密码</a>
                                </li>
                                <li><a href="/admin/user/admin_logout"><i class="fa fa-sign-out fa-fw"></i> 退出系统</a>
                       	 </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>