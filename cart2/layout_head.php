<?php
$_SESSION['cart']=isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <title><?php echo isset($page_title) ? $page_title : "pizza"; ?></title>

	<link href="libs/css/bootstrap/dist/css/bootstrap.css" rel="stylesheet" media="screen">


	<link rel="stylesheet" href="libs/js/bootstrap-image-gallery/css/blueimp-gallery.min.css">
	<link rel="stylesheet" href="libs/js/bootstrap-image-gallery/css/bootstrap-image-gallery.min.css">


    <style>
    .cart-quantity-dropdown {
        float: left;
        width: 100px;
        margin-right: 10px;
    }
    .text-align-center{ text-align:center; }
    .f-w-b{ font-weight:bold; }
    .display-none{ display:none; }
    .table > tbody > tr > td, .table > tbody > tr > th{ border:none; }

    .w-5-pct{ width:5%; }
    .w-10-pct{ width:10%; }
    .w-15-pct{ width:15%; }
    .w-20-pct{ width:20%; }
    .w-25-pct{ width:25%; }
    .w-30-pct{ width:30%; }
    .w-35-pct{ width:35%; }
    .w-40-pct{ width:40%; }
    .w-45-pct{ width:45%; }
    .w-50-pct{ width:50%; }
    .w-55-pct{ width:55%; }
    .w-60-pct{ width:60%; }
    .w-65-pct{ width:65%; }
    .w-70-pct{ width:70%; }
    .w-75-pct{ width:75%; }
    .w-80-pct{ width:80%; }
    .w-85-pct{ width:85%; }
    .w-90-pct{ width:90%; }
    .w-95-pct{ width:95%; }
    .w-100-pct{ width:100%; }

    .w-200-px{ width:200px !important; }
    .m-t-0px{ margin-top:0px; }
    .m-b-10px{ margin-bottom:10px; }
    .m-b-20px{ margin-bottom:20px; }
    .m-b-30px{ margin-bottom:30px; }
    .m-b-40px{ margin-bottom:40px; }

    .stock-text {
        font-weight: bold;
        color: #008a00;
    }

    .stock-text-red{
        font-weight:bold;
        color:#b12704;
    }

    .product-detail {
        font-weight: bold;
        margin: 0 0 5px 0;
    }

    .blueimp-gallery>.prev, .blueimp-gallery>.next{ border:none; }

    .update-quantity-form {
        width: 150px;
        float: left;
        margin: 0 10px 0 0;
    }

    .cart-row {
        border-bottom: thin solid #f1f1f1;
        overflow: hidden;
        width: 100%;
        padding: 20px 0 20px 0;
    }

    .product-link{
        color:#000000;
    }

    .product-link:hover{
        color:#000000;
        text-decoration:none;
    }

    .product-img-thumb {
        margin: 0 0 10px 0;
        width: 100%;
        cursor: pointer;
    }#pic{
        height:350px;
        width:250px;
    }


    </style>

</head>
<body>

	<?php include 'navigation.php'; ?>

    <!-- container -->
    <div class="container">
        <div class="row">

        <div class="col-md-12">
            <div class="page-header">
                <h1><?php echo isset($page_title) ? $page_title : "pizza"; ?></h1>
            </div>
        </div>
