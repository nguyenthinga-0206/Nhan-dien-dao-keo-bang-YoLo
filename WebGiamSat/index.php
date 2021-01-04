<!DOCTYPE html>
<html>
<head>
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial;
  padding: 10px;
  background: #f1f1f1;
}

/* Header/Blog Title */
.header {
height:10%;
width:100%;
background-image:url(https://img.lovepik.com/photo/50101/6358.jpg_wh860.jpg);
padding:10px;
margin-bottom: 10px;
text-align: left;
}

.header h2 {
  font-size: 50px;
  text-align: LEFT;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 5px 5px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn {   
  float: center;
  width: 60%; 
  height: 60%
}

/* Right column */
/* .rightcolumn {
  float: right;
  width: 32%;
  height: 5%;
  /* background-color: #f1f1f1; */
  /* padding-left: 20px; */
} */

.left {   
  float:left;
  width: 100%; 
  height: 100%
}

/* Right column */


/* Fake image */
.fakeimg {
  background-color: white;
  width: 60%;
  height: 60%;
    /* border: 1px solid #333;  */
  /* padding: 5px; */
  margin-left: 20%;
  /* margin-right: 10px; */
}

/* Add a card effect for articles */
.card {
  background-color: white;
  /* padding: 1px; */
  margin-top: 5px;
  text-align: center; 
}
.card1{
  background-color: skyblue;
  /* padding: 1px; */
  /* margin-top: 10px; */
  text-align: left; 
}

/* Clear floats after the columns */
.clear {
  content: "";
  /* display: table; */
  clear: both;
}


</style>
</head>
<body> 

<div class="header">

    <font color="navy"><span style="font-size:25px"><B> TRANG WEB GIÁM SÁT NHÀ TRẺ </B></SPAN></FONT>
   <BR><font color="navy"><span style="font-size:15px"><B> FOR KINDERGARDEN WEBPAGE　</B></SPAN></FONT>
  <BR>
  <br>
  <font color="black"><span style="font-size:15px"> 📧 <i> Email:  abc@gmail.com</i></SPAN></FONT>
  <BR> <font color="black"><span style="font-size:15px"> 📞 <i> Tel: 02363540646 </i></SPAN></FONT>
  
 
   
   
  
  <div class="clear"></div>
  
</div>

</div>

<div class="topnav">
  <a href="/tim_kiem_sua.php">🔍Lịch sử </a>
  <!-- <a href="/DoanWeb/lich_su_img.php">History</a> -->
</div>
<br>

<div class="row">
    <div class="card">
      <h2><b>Hiển thị ảnh mới nhất được nhận dạng</b></h2>
      <div class="fakeimg">  <?php include('/var/www/html/moi_nhat.php');?></div>  
    </div>
  </div>
  
  <div class="clear"></div>
  
</div>
</body>
</html>

