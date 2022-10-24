<?php
if (!isset($_GET['t'])) {
  exit('<iframe src="https://ricehung29.github.io/CSWCSS_ChiArticle/error_pages/page-not-found.html">
    
    <style media="screen">
		  html,body,iframe {
			margin: 0;
			padding: 0;
		  }
		  html,body {
			height: 100%;
			overflow: hidden;
		  }
		  iframe {
			width: 100%;
			height: 100%;
			border: 0;
		  }
		</style>
    ');
}

$verify = json_decode(file_get_contents('https://ricehung29.github.io/CSWCSS_ChiArticle/state.json'), true);

if ($verify['isUpdating'] == 0 || (isset($_GET['isUpdating']) && $_GET['isUpdating'] == 1)) {
  $sys = json_decode(file_get_contents($verify['manifestLink']), true);

  $data_source = $_GET['t'];
  $passage_source = file_get_contents('https://drive.google.com/uc?id=' . $data_source . '');
  $passage = json_decode($passage_source, true);
  clearstatcache();

  $title = $passage["title"];
  $author = $passage["author"];
  $year = $passage["year"];
  $content = $passage["content"];

  $page_title = $title . " - " . $sys["title"];
  $page_description = $title . "  作者：" . $author . "  年份：" . $year . "  - " . $sys["title"];
  $page_url = $sys['sharingLink'] . "view_article.php?t=" . $data_source;
} else {
  exit('' . $verify['updateMessage'] . '');
}

?>

<!doctype html>
<html lang="zh-Hant-HK" class="h-100">

<head>

  <link rel="icon" type="image/x-icon" href="<?php echo $sys["navBarIconLink"]; ?>">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.104.2">

  <!-- HTML Meta Tags -->
  <meta name="description" content="<?php echo $title; ?>">

  <!-- Facebook Meta Tags -->
  <meta property="og:url" content="<?php echo $page_url; ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo $page_title; ?>">
  <meta property="og:description" content="">
  <meta property="og:image" content="https://www.cswcss.edu.hk/uploads/1/0/9/0/109036773/published/school-footer-logo.png?1597908641">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta property="twitter:domain" content="insiderwebhost.ricehungcloud.win">
  <meta property="twitter:url" content="<?php echo $page_url; ?>">
  <meta name="twitter:title" content="<?php echo $page_title; ?>">
  <meta name="twitter:description" content="">
  <meta name="twitter:image" content="https://www.cswcss.edu.hk/uploads/1/0/9/0/109036773/published/school-footer-logo.png?1597908641">

  <title><?php echo $title . " - " . $sys["title"]; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+HK:wght@500;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Noto Serif HK', serif;
      background-image: url('<?php echo $sys['articleImageLink'] ?>');
    }

    main>.container {
      padding: 60px 15px 0;
    }

    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  </style>

</head>

<body class="d-flex flex-column h-100">

  <header>
    <div class="navbar shadow-sm bg-light" style="background-color: <?php echo $sys["navBarColor"] ?>;">
      <div class="container">

        <a href="./index.php" class="d-flex align-items-center text-decoration-none">
          <img class="bi me-2" width="<?php echo $sys["navBarIconWidth"]; ?>" height="<?php echo $sys["navBarIconHeight"]; ?>" role="img" src="<?php echo $sys["navBarIconLink"]; ?>"></img>
        </a>

        <a href="./index.php" class="navbar-brand d-flex align-items-center">
          <strong><?php echo $sys["title"] ?></strong>
        </a>
      </div>
    </div>

  </header>

  <main class="flex-shrink-0" style="color:<?php echo $sys['articleTextColor'] ?>;">
    <div class="container">
      <strong>
        <p class="fs-1"><?php echo $title; ?></p>
      </strong>
      <div class="contenthead d-flex mb-3">
        <p class="lead h4 p-2 me-auto"><?php echo $author . ' - ' . $year; ?></em></p>
        <?php
        if ($verify['enableSharing']) {
          echo ('<button type="button" id="shareButton" class="btn btn-light p-2 ms-auto" style="border-radius:20px;">分享</button>');
        }
        ?>

      </div>
      <hr>
      <?php
      foreach ($content as $contents) {
        echo '<span class="fs-5" style="white-space:pre-line;">&nbsp;&nbsp;' . $contents . '</span><br><br>';
      } ?>

    </div>
  </main>

  <br>

  <footer class="footer mt-auto py-3">
    <div class="container">
      <p class="float-end mb-1">
        <a href="#" style="text-decoration:none;color:<?php echo $sys['articleTextColor'] ?>;">回到頂部</a>
      </p>
      <span class="" style="color:<?php echo($sys['articleTextColor'] . ';">' . $sys["copyright"]); ?></span>
    </div>
  </footer>


  <script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>

        <?php
        if ($verify['enableSharing']) {
          echo ("
          <script>
          const btn = document.getElementById('shareButton');
      
          btn.addEventListener('click', async () => {
            try {
              await navigator.share({
                title: '" . $page_title . "',
                text: '',
                url:'" . $page_url . "'
              });
            } catch (error) {
              // Something
            }
      
          });
        </script>
          ");
        }
        ?>


</body>

</html>

<!-- (C) CSWCSS 2022-->

