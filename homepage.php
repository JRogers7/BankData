<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
    crossorigin="anonymous">
    <link rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
</head>

<style>
      .bankicon{
          font-size:150;
          margin-bottom:10;
      }
      .titletext {
          font-family: Georgia, 'Times New Roman', Times, serif;
          margin-bottom: 35;
          font-size:48;
      }
  </style>
<body>
    

<div class = "bankicon" align="center"><i class="bi bi-bank fa-lg"></i></div>
    <div class = "titletext" align="center">BANKDATA</div>
    <div><h3> <a href ="logout.php">Log Out</a></h3></div>
    <br><br><br>
    
    <?php
        session_start();
        echo "<h2>Welcome, " . $_SESSION['username'] . "</h2>";
    ?>
</body>