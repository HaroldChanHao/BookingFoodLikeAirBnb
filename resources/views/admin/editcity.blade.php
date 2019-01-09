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
                    <h1 class="page-header">修改城市</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            修改城市
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" enctype="multipart/form-data" method="post" action="">
                                    		@csrf
                                    		<div class="form-group">
                                            <label>请选择国家</label>
                                            <select id="conName" name="conName" class="form-control">
                                            		<option value="Germany">Germany</option>
                                            		<option value="China">China</option>
                                            		<option value="France">France</option>
                                            		<option value="UK">UK</option>
                                            		<option value="USA">USA</option>
                                            		<option value="Canada">Canada</option>
                                            		<option value="Australia">Australia</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>城市名称</label>
                                            <input type="text" id="cityName" name="cityName" class="form-control" placeholder="城市名称" value="{{$data->city_name}}">
                                        </div>
                                        <div class="form-group">
                                            <label>城市封面</label>
                                           	@if ($data->city_pic <> '')
											    <img src="/uploads/{{$data->city_pic}}" width="300">											
											@endif
											<INPUT name="cityPic[]" class="input-text" id="cityPic" type="file" data-file_types="jpg|jpeg|gif|png">
                                        </div>
                                        
                                        <button id="submit" type="submit" class="btn btn-default">提交</button>
                                        <button type="reset" class="btn btn-default">重置</button>
                                    </form>
                                </div>       
                            </div>
                            <!-- /.row (nested) -->
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
			if ($('#classTitle').val() == '') {
				alert("请填写分类标题");
				return false;
			}        
        });
    </script>
    {!! $script !!}

</body>

</html>
