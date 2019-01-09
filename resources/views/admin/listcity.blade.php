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
                    <h1 class="page-header">城市列表</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            城市列表详情
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline dt-bootstrap no-footer">
                            		<form role="form" method="get" action="">
                                		@csrf
	                            		<div class="row">
	                            			<div class="col-sm-6"></div>
	                            			<div class="col-sm-6">
	                            				<div id="dataTables-example_filter" class="dataTables_filter">
	                            					<input type="text" name="keyWords" value="{{$keyWords}}" class="form-control" placeholder="搜索"> <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
	                            				</div>
	                            			</div>
	                            		</div>
	                            	</form>
                            		<div class="row">
                            			<div class="col-sm-12">
                            				<table width="100%" class="table table-striped table-bordered table-hover dataTable no-footer dtr-inline" id="dataTables" role="grid" aria-describedby="dataTables-example_info" style="width: 100%;">
                                				<thead>
                                    				<tr role="row">
                                    					<th>序号</th>
                                    					<th>城市</th>
                                    					<th>国家</th>
                                    					<th>操作</th>
                                    				</tr>
                                				</thead>
                                				<tbody>    
                                					@forelse ($cityData as $data)
												    <tr class="gradeA @if ($loop->index % 2 == 0) 
												    			even
												    		@else 
												    			odd
												    		@endif" role="row">
				                                        <td class="center">{{$loop->index + 1}}</td>
				                                        <td>{{$data->city_name}}</td>
				                                        <td>{{$data->con_name}}</td>
				                                        <td><a href="/admin/activity/edit_city?id={{$data->id}}">编辑</a></td>
	                           						</tr>
												@empty
												    <p>没有数据</p>
												@endforelse
                                				</tbody>
                            				</table>
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$('#submit').click(function(){
			if ($('#cityTitle').val() == '') {
				alert("请填写城市名称");
				return false;
			}        
        });
    </script>
    {!! $script !!}

</body>

</html>
