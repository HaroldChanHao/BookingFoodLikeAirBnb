<!DOCTYPE html>
<html lang="zh-cn">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MEALMIR Admin</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- bootstrap-datetimepicker Core CSS -->
    <link href="../vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style type="text/css">
		#dataTables th {
			text-align: center;
		}
		#dataTables .gradeA {
			text-align: center;
		}
	</style>
</head>

<body>

    <div id="wrapper">
    		
    		@include('admin.menu')
    		
        <div id="page-wrapper">
        		<div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">进行中的订单</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            进行中的订单
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
	                            	<form role="form" method="get" action="" enctype="application/x-www-form-urlencoded">
	                                		@csrf
	                            		<div class="row">
	                            			<div class="col-sm-12">
	                            				<div id="dataTables-example_filter" class="dataTables_filter">
	                            					<input type="text" value="" placeholder="开始时间"  class="form-control form_datetime" size="13" name="start" id="start"> -<input type="text" value="" placeholder="结束时间"  class="form-control form_datetime" size="13" name="end" id="end">
											    	<input type="hidden" value="{{$stas}}" name="stas">
											    	<input type="text" class="form-control" name="keyWrods" placeholder="关键词"> <button type="submit" class="btn btn-default" id="secBtn"><i class="fa fa-search"></i></button>
	                            				</div>
	                            			</div>
	                            		</div>
	                            	</form>
                            		<div class="row">
                            			<div class="col-sm-12">
                            				<table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                				<thead>
                                    				<tr role="row">
                                    					<th></th>
                                    					<th>相关活动</th>
                                    					<th>订单用户</th>
                                    					<th>订单人数</th>
                                    					<th>预订时间</th>
                                    					<th>操作</th>
                                    				</tr>
                                				</thead>
                                				<tbody>
                                					@forelse ($odrData as $odrData)
	                                					<tr class="gradeA @if ($loop->index % 2 == 0) 
													    			even
													    		@else 
													    			odd
													    		@endif" role="row">
				                                        <td class="center">{{$loop->index + 1}}</td>
				                                        <td>{{$odrData->act_name}} <a href="/actshowprev?id={{$odrData->act_id}}" target="_blank">预览</a></td>
				                                        <td>{{$odrData->user_email}}</td>
				                                        <td>{{$odrData->order_number}}</td>
				                                        <td>{{$odrData->order_create}}</td>
				                                        <td>
			                                        			<a href="javascript:void(0)" onclick="confirm('确认结单？')?location.href='/admin/order/mod_odr?id={{$odrData->id}}&stas=1':'';">结单</a>		                                        		
				                                        </td>
	                           						</tr>												    
												@empty
												    <p>没有数据</p>
												@endforelse
											</tbody>
                            				</table>
                            			</div>
                            		</div>
                            		<div class="row" style="display: none;">
                            			<div class="col-sm-6"></div>
                        				<div class="col-sm-6">
                        					<div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                        						<ul class="pagination">
                        							<li class="paginate_button previous disabled" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_previous">
                        								<a href="#">Previous</a>
                        							</li>
                        							<li class="paginate_button active" aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">1</a>
                        							</li>
                        							<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">2</a>
                        							</li>
                        							<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">3</a>
                        							</li>
                        							<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">4</a>
                        							</li>
                        							<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">5</a>
                        							</li>
                        							<li class="paginate_button " aria-controls="dataTables-example" tabindex="0">
                        								<a href="#">6</a>
                        							</li>
                        							<li class="paginate_button next" aria-controls="dataTables-example" tabindex="0" id="dataTables-example_next">
                        								<a href="#">Next</a>
                        							</li>
                        						</ul>
                        					</div>
                        				</div>
                            		</div>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    <script src="../vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script type="text/javascript">
	    $(".form_datetime").datetimepicker({
	        autoclose: true,
	        todayBtn: true,
	    });
	    $('#secBtn').click(function() {
	    		if ($('#dateType').val()) {
	    			if ($('#start').val() == '') {
	    				alert('请选择开始时间');
	    				return false;
	    			} else if ($('#end').val() == '') {
	    				alert('请选择结束时间');
	    				return false;
	    			}
	    		}
	    })
	</script>

</body>

</html>
