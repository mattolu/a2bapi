{{-- <html>
    <body>
    <h1>Dear {{ $lastname }} {{ $firstname }}</h1><br>
        <h3>Please login to the application using the following credentials</h3>
        <h3>Email: {{ $email }}</h3>
        <h3>Password: {{ $password }}</h3>
        <h2>Kind regards, <br> A2B Tech Team</h2>
    </body>
</html> --}}

<html>
 <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>a2b Newsletter</title>

    <!-- Bootstrap -->
     <link href= {{url('css/bootstrap.min.css')}} rel="stylesheet"  type="text/css">
    <link rel="stylesheet" type="text/css" href={{url('css/email.css')}}>
    <!-- fontawesome script -->
    <link rel="stylesheet" type="text/css" href= {{url('css/font-awesome.css')}}>
    <link href= {{url('https://fonts.googleapis.com/css?family=Montserrat')}} rel="stylesheet">
    <link href= {{url('https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css')}} rel='stylesheet'/>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <style>
            html, body{
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	font-family: 'Montserrat', sans-serif;
}

.container{
	background-color: #f1f0f0;
	width: 100%;
	min-height: 100vh;
	display: flex;
	justify-content: center;
	height:100%;
	margin: 0;
	padding: 0;
}
h5{
	line-height: 20px;
}
.email_container{
	background-color:#fff;
	width:35%;
	margin-top:5%;
	max-height: 80%;
	border-radius:10px;
}
.span{
	color:#2943b9;
	font-weight: 800;
}
.write_up_short{
	text-align: left;	
}
.write_up_long{
	text-align: justify;	
	min-height:10vh;
}
.email_head{
	background-color: #2943b9;	
	height:100px;
	width: 100%;
	padding-top:5%;
	text-align: center;
	border-radius: 10px 10px 0 0;
	
}
.left_side{
	float:left;
}
.email_body{
	background-color: #fff;	
	height: calc(100% - 160px);
	width: 100%;
	padding:10% 10%;
	padding-top:5%;
	text-align: center;
}
.email_foot{
	background-color: #f6f6f6;	
	height:60px;
	width: 100%;
	display: flex;
	justify-content: center;
	text-align: center;
	border-radius: 0px 0px 10px 10px;

	
}

.btn:hover{
	background-color: transparent;
	color: #fff;
}

.list{
	float: left;
	padding: 25px;
	padding-top: 0;
}

.social{
		list-style: none;
		margin: 10px;
		padding: 5px;
}

#fb{
	height: 30px;
	width: 30px;
	border-radius: 20px;
	background-color: #3b5998;
	border:0;
	padding-top: 8px;
}
#ld{
	height: 30px;
	width: 30px;
	border-radius: 20px;
	background-color: #0077b5;
	border:0;
	padding-top: 8px;
	padding-left: 9px;
}
#tw{
	height: 30px;
	width: 30px;
	border-radius: 20px;
	background-color: #08a0e9;
	border:0;
	padding-top: 8px;
	padding-left: 9px;
}
.table_div{
	padding:5% 20%;
}
@media(max-height: 1370px){
	.email_container{
		background-color:#fff;
		width:75%;
		margin-top:10%;
		max-height: 65%;
		border-radius:10px;
	}
	.table_div{
		padding:5% 0%;
		width:100%;
		font-size:10px;
		margin-top:-20px;
	}
}
@media(max-width: 769px){
	.email_container{
		background-color:#fff;
		width:75%;
		margin-top:5%;
		max-height: 80%;
		border-radius:10px;
	}
	.table_div{
		padding:5% 0%;
		width:100%;
		font-size:10px;
		margin-top:-20px;
	}
}
@media(max-width: 370px){
	.email_container{
		background-color:#fff;
		width:85%;
		margin-top:3%;
		max-height: 95%;
		border-radius:10px;
	}
	.table_div{
		padding:5% 0%;
		width:100%;
		font-size:10px;
		margin-top:-20px;
	}
}

        </style>
  </head> 
 <body>
      <!-- Main Container -->
    <div class="container">
        <!-- Email Middle Container -->
        <div class="email_container">
            <!-- Email Header -->
            <section class="email_head">
                {{-- <img src= {{url('images/file2.png')}} />
                &nbsp;&nbsp;
                <img src= {{url('images/a2b.png')}}/> --}}
                <h1 style="color:#fff;">a2b </h1>
            </section>
            <!-- Email Header End Here -->
            <!-- Email Body Container -->
            <section class="email_body"> 
               <div class="write_up_short">
                    <h5>Dear {{ $lastname }} {{ $firstname }}</h5><br>
               </div>
               <div  class="write_up_long">
                    <p>Thank you for registering with a2b Logistics. Please find herein below your login details:</p>
               </div>
                <div class="table_div">
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th scope="col">email</th>
                                <th scope="col">{{ $email }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="col">password</th>
                                <th scope="col">{{ $password }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="write_up_long">
                    <h5>If you run into any technical issues or inability to have access to the a2b application Platform. Please, Contact: <span class="span">isues@a2b.com</span></h5><br>
                </div>
            </section> 
            <!-- Email Body Container Ends here -->
            <!-- Email Footer -->
            <section class="email_foot">    
                <ul class="social">             
                    <li class="list"><a href="#"><i id="fb" class="btn btn-success fa fa-facebook"></i></a></li> 
                    <li class="list"><a href="#"><i id="ld" class="btn btn-success fa fa-linkedin"></i></a></li>       
                    <li class="list"><a href="#"><i id="tw" class="btn btn-success fa fa-twitter"></i></a></li>               
                </ul>      
            <!-- </section>Email footer Ends here -->
         </div>
         <!-- Email Middle Container Ends here -->
    </div>
    <!-- Main Container Ends here -->
    <script src= {{'js/bootstrap.min.js'}}></script>
   
  </body>
</html>
