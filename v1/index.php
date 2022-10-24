<?php

$verify = json_decode(file_get_contents('https://ricehung29.github.io/CSWCSS_ChiArticle/state.json'), true);

if ($verify['isUpdating'] == 0 || (isset($_GET['isUpdating']) && $_GET['isUpdating'] == 1)) {
  $sys = json_decode(file_get_contents($verify['manifestLink']), true);

  $welcome = json_decode(file_get_contents('https://data.weather.gov.hk/weatherAPI/opendata/weather.php?dataType=flw&lang=tc'), true);

  $lunar = new Lunar();
  $month = $lunar->convertSolarToLunar(date('Y'), date('m'), date('d'));
} else {
  exit('' . $verify['updateMessage'] . '');
}

function getSheets($sheetsurl)
{
  $file_to_read = fopen($sheetsurl, 'r');
  while (!feof($file_to_read)) $lines[] = fgetcsv($file_to_read);
  fclose($file_to_read);
  clearstatcache();
  return array_slice($lines, 1);
}

?>

<!DOCTYPE html>
<html lang="zh-Hant-HK">

<head>

  <link rel="icon" type="image/x-icon" href="<?php echo $sys["navBarIconLink"]; ?>">

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.101.0">

  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />

  <title>主頁 - <?php echo $sys["title"] ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+HK:wght@500;900&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Noto Serif HK', serif;
      background-image: url('<?php echo $sys['titleImageLink'] ?>');
      background-size: auto;
    }

    main>.container {
      padding: 60px 15px 0;
    }

    .bg-image {
      width: 100%;
      height: 150%;
    }

    .bd-placeholder-img {
      font-size: 1.5rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
      margin-top: 5%;
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

    .carousel-inner {
      height: fit-content;
      block-size: fit-content;
      overflow: visible;
    }
  </style>


</head>

<header>
  <div class="collapse bg-light" id="navbarHeader">
    <div class="container">

      <div class="row">
        <div class="col-sm-8 col-md-7 py-4">
          <h4 class="text-black">關於此網站</h4>
          <p class="text-muted"><?php echo $sys["description"] . '<br>' . $sys['version']; ?></p>
        </div>
        <div class="col-sm-4 offset-md-1 py-4">
          <h4 class="text-black">聯絡</h4>
          <p class="text-muted"><?php echo $sys["contact"]; ?></p>
          <br>
        </div>
      </div>
    </div>
  </div>

  <div class="navbar shadow-sm bg-light" style="background-color: <?php echo $sys["navBarColor"] ?>;display:flex;white-space: nowrap;">
    <div class="container">
      <a href="./index.php" class="d-flex align-items-center text-decoration-none" width="50%">
        <img class="bi me-2" width="<?php echo $sys["navBarIconWidth"]; ?>" height="<?php echo $sys["navBarIconHeight"]; ?>" role="img" src="<?php echo $sys["navBarIconLink"]; ?>"></img>
      </a>

      <a href="./index.php" class="navbar-brand d-flex align-items-center">
        <strong><?php echo $sys["title"] ?></strong>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>


  <?php

  if ($verify['enableMessage']) {
    echo ('
            <div class="alert alert-' . $verify['messageColor'] . '" role="alert" style="margin:0 0 0 0;">
              ' . $verify['messageContent'] . '
            </div>
        ');
  }
  ?>

</header>

<body>
<br><br>
  <main>
      <div class="carousel-inner ">
          <svg class="bd-placeholder-img" width="100%" height="max-content" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"></svg> <!-- <img class="bd-placeholder-img" src="<?php echo $sys["titleImageLink"]; ?>" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false" width=100% height=120% ></img> -->
          <div class="carousel-caption text-end" style="color:<?php echo $sys["titleColor"]; ?>;margin-top:50%;margin-bottom:0px;padding-bottom:0px;">
            <strong>
              <p class="fs-3"><?php echo ($month[3] . "年 " . $month[1] . $month[2]); ?></p>
              <p class="fs-5"><?php echo (date("Y年m月d日")) ?></p>
            </strong>
            <p style="margin-bottom:0px;width=150%;" class="fs-6"><?php echo $welcome["forecastDesc"]; ?></p>
          </div>
      </div>

    <style>
      .searchbar {
        margin-bottom: auto;
        margin-top: auto;
        height: 30%;
        background-color: rgb(239, 254, 236);
        border-radius: 30px;
        padding: 3px;
        color: white;
      }

      .search_input {
        border: 0;
        outline: 0;
        background: none;
        width: 90%;
        caret-color: black;
        line-height: 30px;
        padding: 0 5px;
        transition: width 0.4s linear;
      }

      .search_icon {
        color: black;
      }
    </style>

    <?php
    if (!isset($_GET['folderID']) && $verify['enableTypeSorting'] == 1) {
      if (isset($_GET['sort']) && $_GET['sort'] == 'type') {
        echo ('
        <div class="album py-5 text-center fs-3 ">
        <div class="btn-group" role="group" aria-label="Basic example">
              <a type="button" class="btn btn-secondary fs-5" href="./index.php?sort=year" >以年份排序</a>
              <a type="button" class="btn btn-success fs-5" href="./index.php?sort=type" >以類型排序</a>
            </div>
        <br><br>
        ');
      } else {
        echo ('
        <div class="album py-5 text-center fs-3 ">
        <div class="btn-group" role="group" aria-label="Basic example">
              <a type="button" class="btn btn-success fs-5" href="./index.php?sort=year" >以年份排序</a>
              <a type="button" class="btn btn-secondary fs-5" href="./index.php?sort=type" >以類型排序</a>
            </div>
        <br><br>
        ');
      }
    }
    ?>

    <div class="container">
      <?php
      if (isset($_GET['folderID'])) {
        if ($_GET['sort'] == 'type') {
          echo ('<h4 class="fs-3">類型為' . $_GET['folderID'] . '的文章 :</h4><br>');
        } else {
          echo ('<h4 class="fs-3">' . $_GET['folderID'] . '年度的文章 :</h4><br>');
        }
      } ?>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <?php if (isset($_GET['folderID'])) {
          $lines = getSheets($sys["PassageCSVLink"]);
          $type = $_GET['folderID'];

          foreach ($lines as $value) {
            if ($_GET['sort'] == 'type') {
              $choose = $value[5];
            } else {
              $choose = $value[3];
            }

            if ($type == $choose) {
              $url = './view_article.php?t=' . $value[0];
              echo '
                <div class="col">
                  <div class="card shadow-sm" style="border-radius: 20px;">
                    <div class="card-body"  >
                      <a class="card-text fs-3" style="color:black; text-decoration:none" href="' . $url . '" ><strong>' . $value[1] . '</strong></a>
                      <br><br>
                      <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">' . $value[2] . ' - ' . $value[3] . '</small>
                        <small class="text-muted">類型：' . $value[5] . '</small>
                      </div>
                    </div>
                  </div>
                </div>';
            }
          }
        } else {
          if (isset($_GET['sort']) && $_GET['sort'] == 'type') {
            $lines = getSheets($sys["TypeFolderCSVLink"]);

            foreach ($lines as $value) {
              echo '
              <a class="col" href="./index.php?folderID=' . $value[1] . '&sort=type" style="text-decoration: none;" >
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="width:100%;height:100%;background-size: 100% 100%;background-image: url(' . $value[0] . ');">
                  <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">類型：' . $value[1] . '</h3>
                  </div>
                </div>
              </a>
                ';
            }
          } else {
            $lines = getSheets($sys["YearFolderCSVLink"]);

            foreach ($lines as $value) {
              echo '
              <a class="col" href="./index.php?folderID=' . $value[1] . '&sort=year" style="text-decoration: none;" >
                <div class="card card-cover h-100 overflow-hidden text-bg-dark rounded-4 shadow-lg" style="width:100%;height:100%;background-size: 100% 100%;background-image: url(' . $value[0] . ');">
                  <div class="d-flex flex-column h-100 p-5 pb-3 text-white text-shadow-1">
                    <h3 class="pt-5 mt-5 mb-4 display-6 lh-1 fw-bold">' . $value[1] . '年度</h3>
                  </div>
                </div>
              </a>
                ';
            }
          }
        }

        ?>

      </div>
    </div>
    </div>

  </main>

  <footer class="text-muted py-5 ">
    <div class="container">
      <p class="float-end mb-1">
        <a href="#" style="text-decoration:none;">回到頂部</a>
      </p>
      <p class="mb-1"><?php echo $sys["copyright"]; ?></p>
    </div>
  </footer>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

</body>

</html>

<!-- (C) CSWCSS 2022-->


<?php
#Lunar Calendar Conversion - until 2100

class Lunar
{
  const MIN_YEAR = 1891;
  const MAX_YEAR = 2100;

  const LUNAR_INFO = [
    [0, 2, 9, 21936], [6, 1, 30, 9656], [0, 2, 17, 9584], [0, 2, 6, 21168], [5, 1, 26, 43344], [0, 2, 13, 59728],
    [0, 2, 2, 27296], [3, 1, 22, 44368], [0, 2, 10, 43856], [8, 1, 30, 19304], [0, 2, 19, 19168], [0, 2, 8, 42352],
    [5, 1, 29, 21096], [0, 2, 16, 53856], [0, 2, 4, 55632], [4, 1, 25, 27304], [0, 2, 13, 22176], [0, 2, 2, 39632],
    [2, 1, 22, 19176], [0, 2, 10, 19168], [6, 1, 30, 42200], [0, 2, 18, 42192], [0, 2, 6, 53840], [5, 1, 26, 54568],
    [0, 2, 14, 46400], [0, 2, 3, 54944], [2, 1, 23, 38608], [0, 2, 11, 38320], [7, 2, 1, 18872], [0, 2, 20, 18800],
    [0, 2, 8, 42160], [5, 1, 28, 45656], [0, 2, 16, 27216], [0, 2, 5, 27968], [4, 1, 24, 44456], [0, 2, 13, 11104],
    [0, 2, 2, 38256], [2, 1, 23, 18808], [0, 2, 10, 18800], [6, 1, 30, 25776], [0, 2, 17, 54432], [0, 2, 6, 59984],
    [5, 1, 26, 27976], [0, 2, 14, 23248], [0, 2, 4, 11104], [3, 1, 24, 37744], [0, 2, 11, 37600], [7, 1, 31, 51560],
    [0, 2, 19, 51536], [0, 2, 8, 54432], [6, 1, 27, 55888], [0, 2, 15, 46416], [0, 2, 5, 22176], [4, 1, 25, 43736],
    [0, 2, 13, 9680], [0, 2, 2, 37584], [2, 1, 22, 51544], [0, 2, 10, 43344], [7, 1, 29, 46248], [0, 2, 17, 27808],
    [0, 2, 6, 46416], [5, 1, 27, 21928], [0, 2, 14, 19872], [0, 2, 3, 42416], [3, 1, 24, 21176], [0, 2, 12, 21168],
    [8, 1, 31, 43344], [0, 2, 18, 59728], [0, 2, 8, 27296], [6, 1, 28, 44368], [0, 2, 15, 43856], [0, 2, 5, 19296],
    [4, 1, 25, 42352], [0, 2, 13, 42352], [0, 2, 2, 21088], [3, 1, 21, 59696], [0, 2, 9, 55632], [7, 1, 30, 23208],
    [0, 2, 17, 22176], [0, 2, 6, 38608], [5, 1, 27, 19176], [0, 2, 15, 19152], [0, 2, 3, 42192], [4, 1, 23, 53864],
    [0, 2, 11, 53840], [8, 1, 31, 54568], [0, 2, 18, 46400], [0, 2, 7, 46752], [6, 1, 28, 38608], [0, 2, 16, 38320],
    [0, 2, 5, 18864], [4, 1, 25, 42168], [0, 2, 13, 42160], [10, 2, 2, 45656], [0, 2, 20, 27216], [0, 2, 9, 27968],
    [6, 1, 29, 44448], [0, 2, 17, 43872], [0, 2, 6, 38256], [5, 1, 27, 18808], [0, 2, 15, 18800], [0, 2, 4, 25776],
    [3, 1, 23, 27216], [0, 2, 10, 59984], [8, 1, 31, 27432], [0, 2, 19, 23232], [0, 2, 7, 43872], [5, 1, 28, 37736],
    [0, 2, 16, 37600], [0, 2, 5, 51552], [4, 1, 24, 54440], [0, 2, 12, 54432], [0, 2, 1, 55888], [2, 1, 22, 23208],
    [0, 2, 9, 22176], [7, 1, 29, 43736], [0, 2, 18, 9680], [0, 2, 7, 37584], [5, 1, 26, 51544], [0, 2, 14, 43344],
    [0, 2, 3, 46240], [4, 1, 23, 46416], [0, 2, 10, 44368], [9, 1, 31, 21928], [0, 2, 19, 19360], [0, 2, 8, 42416],
    [6, 1, 28, 21176], [0, 2, 16, 21168], [0, 2, 5, 43312], [4, 1, 25, 29864], [0, 2, 12, 27296], [0, 2, 1, 44368],
    [2, 1, 22, 19880], [0, 2, 10, 19296], [6, 1, 29, 42352], [0, 2, 17, 42208], [0, 2, 6, 53856], [5, 1, 26, 59696],
    [0, 2, 13, 54576], [0, 2, 3, 23200], [3, 1, 23, 27472], [0, 2, 11, 38608], [11, 1, 31, 19176], [0, 2, 19, 19152],
    [0, 2, 8, 42192], [6, 1, 28, 53848], [0, 2, 15, 53840], [0, 2, 4, 54560], [5, 1, 24, 55968], [0, 2, 12, 46496],
    [0, 2, 1, 22224], [2, 1, 22, 19160], [0, 2, 10, 18864], [7, 1, 30, 42168], [0, 2, 17, 42160], [0, 2, 6, 43600],
    [5, 1, 26, 46376], [0, 2, 14, 27936], [0, 2, 2, 44448], [3, 1, 23, 21936], [0, 2, 11, 37744], [8, 2, 1, 18808],
    [0, 2, 19, 18800], [0, 2, 8, 25776], [6, 1, 28, 27216], [0, 2, 15, 59984], [0, 2, 4, 27424], [4, 1, 24, 43872],
    [0, 2, 12, 43744], [0, 2, 2, 37600], [3, 1, 21, 51568], [0, 2, 9, 51552], [7, 1, 29, 54440], [0, 2, 17, 54432],
    [0, 2, 5, 55888], [5, 1, 26, 23208], [0, 2, 14, 22176], [0, 2, 3, 42704], [4, 1, 23, 21224], [0, 2, 11, 21200],
    [8, 1, 31, 43352], [0, 2, 19, 43344], [0, 2, 7, 46240], [6, 1, 27, 46416], [0, 2, 15, 44368], [0, 2, 5, 21920],
    [4, 1, 24, 42448], [0, 2, 12, 42416], [0, 2, 2, 21168], [3, 1, 22, 43320], [0, 2, 9, 26928], [7, 1, 29, 29336],
    [0, 2, 17, 27296], [0, 2, 6, 44368], [5, 1, 26, 19880], [0, 2, 14, 19296], [0, 2, 3, 42352], [4, 1, 24, 21104],
    [0, 2, 10, 53856], [8, 1, 30, 59696], [0, 2, 18, 54560], [0, 2, 7, 55968], [6, 1, 27, 27472], [0, 2, 15, 22224],
    [0, 2, 5, 19168], [4, 1, 25, 42216], [0, 2, 12, 42192], [0, 2, 1, 53584], [2, 1, 21, 55592], [0, 2, 9, 54560],
  ];

  const SKY = [
    '庚', '辛', '壬', '癸',
    '甲', '乙', '丙', '丁',
    '戊', '己',
  ];

  const EARTH = [
    '申', '酉', '戌', '亥',
    '子', '丑', '寅', '卯',
    '辰', '巳', '午', '未',
  ];

  const ZODIAC = [
    '猴', '雞', '狗', '豬', '鼠', '牛',
    '虎', '兔', '龍', '蛇', '馬', '羊',
  ];

  const DATE_HASH = [
    '',
    '一', '二', '三', '四', '五',
    '六', '七', '八', '九', '十',
  ];

  const MONTH_HASH = [
    '',
    '正月', '二月', '三月', '四月', '五月', '六月',
    '七月', '八月', '九月', '十月', '冬月', '臘月',
  ];

  const MONTH_DAYS = [
    31, -1, 31, 30, 31, 30,
    31, 31, 30, 31, 30, 31,
  ];

  /**
   * 將陽曆轉換為陰曆.
   *
   * @param int $year  公曆-年
   * @param int $month 公曆-月
   * @param int $date  公曆-日
   *
   * @return array
   */
  public function convertSolarToLunar(int $year, int $month, int $date): array
  {
    //debugger;
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    if ($year === static::MIN_YEAR && $month <= 2 && $date <= 9) {
      return [1891, '正月', '初一', '辛卯', 1, 1, '兔'];
    }

    return $this->getLunarByBetween(
      $year,
      $this->getDaysBetweenSolar($year, $month, $date, $yearData[1], $yearData[2])
    );
  }

  public function convertSolarMonthToLunar(int $year, int $month): array
  {
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    if ($year === static::MIN_YEAR && $month <= 2 && $date <= 9) {
      return [1891, '正月', '初一', '辛卯', 1, 1, '兔'];
    }

    $dd = $this->getSolarMonthDays($year, $month);
    if ($this->isLeapYear($year) && $month === 2) {
      ++$dd;
    }

    $lunar_ary = [];
    for ($i = 1; $i < $dd; ++$i) {
      $array = $this->getLunarByBetween(
        $year,
        $this->getDaysBetweenSolar($year, $month, $i, $yearData[1], $yearData[2])
      );
      $array[] = $year . '-' . $month . '-' . $i;
      $lunar_ary[$i] = $array;
    }

    return $lunar_ary;
  }

  /**
   * 將陰曆轉換為陽曆.
   *
   * @param int $year  陰曆-年
   * @param int $month 陰曆-月，閏月處理：例如如果當年閏五月，那麼第二個五月就傳六月，相當於陰曆有13個月，只是有的時候第13個月的天數為0
   * @param int $date  陰曆-日
   *
   * @return array
   */
  public function convertLunarToSolar(int $year, int $month, int $date): array
  {
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    $between = $this->getDaysBetweenLunar($year, $month, $date);

    $res = mktime(0, 0, 0, $yearData[1], $yearData[2], $year);
    $res = date('Y-m-d', $res + $between * 24 * 60 * 60);

    return explode('-', $res);
  }

  /**
   * 判斷是否是閏年.
   *
   * @param int $year The year
   *
   * @return bool true if leap year, False otherwise
   */
  public function isLeapYear(int $year): bool
  {
    return ($year & 3 === 0 && $year % 100 !== 0) || ($year % 400 === 0);
  }

  /**
   * 獲取干支紀年.
   *
   * @param int $year The year
   *
   * @return string the lunar year name
   */
  public function getLunarYearName(int $year): string
  {
    return static::SKY[$year % 10] . static::EARTH[$year % 12];
  }

  /**
   * 根據陰曆年獲取生肖.
   *
   * @param int $year 陰曆年
   *
   * @return array the year zodiac
   */
  public function getYearZodiac(int $year): string
  {
    return static::ZODIAC[$year % 12];
  }

  /**
   * 獲取陽曆月份的天數.
   *
   * @param int $year  陽曆-年
   * @param int $month 陽曆-月
   *
   * @return int the solar month days
   */
  public function getSolarMonthDays(int $year, int $month): int
  {
    return $month === 2
      ? ($this->isLeapYear($year) ? 29 : 28)
      : static::MONTH_DAYS[$month];
  }

  /**
   * 獲取陰曆月份的天數.
   *
   * @param int $year  陰曆-年
   * @param int $month 陰曆-月，從一月開始
   *
   * @return int the lunar month days
   */
  public function getLunarMonthDays(int $year, int $month): int
  {
    return $this->getLunarMonths($year)[$month - 1];
  }

  /**
   * 獲取陰曆每月的天數的數組.
   *
   * @param int $year The year
   *
   * @return array the lunar months
   */
  public function getLunarMonths(int $year): array
  {
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    $leapMonth = $yearData[0];
    $bit = decbin($yearData[3]);

    for ($i = 0; $i < strlen($bit); ++$i) {
      $bitArray[$i] = substr($bit, $i, 1);
    }

    for ($k = 0, $klen = 16 - count($bitArray); $k < $klen; ++$k) {
      array_unshift($bitArray, '0');
    }

    $bitArray = array_slice($bitArray, 0, ($leapMonth === 0 ? 12 : 13));
    for ($i = 0; $i < count($bitArray); ++$i) {
      $bitArray[$i] = $bitArray[$i] + 29;
    }

    return $bitArray;
  }

  /**
   * 獲取農曆每年的天數.
   *
   * @param int $year 農曆年份
   *
   * @return int the lunar year days
   */
  public function getLunarYearDays(int $year): int
  {
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    $monthArray = $this->getLunarYearMonths($year);
    $len = count($monthArray);

    return $monthArray[$len - 1] === 0 ? $monthArray[$len - 2] : $monthArray[$len - 1];
  }

  /**
   * 獲取農曆每年的月數.
   *
   * @param int $year The year
   *
   * @return array the lunar year months
   */
  public function getLunarYearMonths(int $year): array
  {
    //debugger
    $monthData = $this->getLunarMonths($year);
    $res = [];
    $temp = 0;
    $yearData = static::LUNAR_INFO[$year - static::MIN_YEAR];
    $len = ($yearData[0] === 0 ? 12 : 13);

    for ($i = 0; $i < $len; ++$i) {
      $temp = 0;
      for ($j = 0; $j <= $i; ++$j) {
        $temp += $monthData[$j];
      }
      $res[] = $temp;
    }

    return $res;
  }

  /**
   * 獲取閏月.
   *
   * @param int $year 陰曆年份
   *
   * @return int the leap month
   */
  public function getLeapMonth(int $year): int
  {
    return static::LUNAR_INFO[$year - static::MIN_YEAR][0];
  }

  /**
   * 計算陰曆日期與正月初一相隔的天數.
   *
   * @param int $year  The year
   * @param int $month The month
   * @param int $date  The date
   *
   * @return int the days between lunar
   */
  public function getDaysBetweenLunar(int $year, int $month, int $date): int
  {
    $yearMonth = $this->getLunarMonths($year);

    $res = 0;
    for ($i = 1; $i < $month; ++$i) {
      $res += $yearMonth[$i - 1];
    }
    $res += $date - 1;

    return $res;
  }

  /**
   * 計算2個陽曆日期之間的天數.
   *
   * @param int $year   陽曆年
   * @param int $cmonth The cmonth
   * @param int $cdate  The cdate
   * @param int $dmonth 陰曆正月對應的陽曆月份
   * @param int $ddate  陰曆初一對應的陽曆天數
   *
   * @return int the days between solar
   */
  public function getDaysBetweenSolar(int $year, int $cmonth, int $cdate, int $dmonth, int $ddate): int
  {
    $a = mktime(0, 0, 0, $cmonth, $cdate, $year);
    $b = mktime(0, 0, 0, $dmonth, $ddate, $year);

    return ceil(($a - $b) / 24 / 3600);
  }

  /**
   * 根據距離正月初一的天數計算陰曆日期
   *
   * @param int $year    陽曆年
   * @param int $between 天數
   *
   * @return array the lunar by between
   */
  public function getLunarByBetween(int $year, int $between): array
  {
    // debugger
    $lunarArray = [];
    $yearMonth = [];
    $t = 0;
    $e = 0;
    $leapMonth = 0;
    $m = '';

    if ($between === 0) {
      array_push($lunarArray, $year, '正月', '初一');
      $t = 1;
      $e = 1;
    } else {
      $year = $between > 0 ? $year : ($year - 1);
      $yearMonth = $this->getLunarYearMonths($year);
      $leapMonth = $this->getLeapMonth($year);
      $between = $between > 0 ? $between : ($this->getLunarYearDays($year) + $between);

      for ($i = 0; $i < 13; ++$i) {
        if ($between === $yearMonth[$i]) {
          $t = $i + 2;
          $e = 1;
          break;
        }
        if ($between < $yearMonth[$i]) {
          $t = $i + 1;
          $e = $between - (empty($yearMonth[$i - 1]) ? 0 : $yearMonth[$i - 1]) + 1;
          break;
        }
      }

      $m = ($leapMonth !== 0 && $t === $leapMonth + 1)
        ? ('閏' . $this->getCapitalNum($t - 1, true))
        : $this->getCapitalNum(($leapMonth !== 0 && $leapMonth + 1 < $t ? ($t - 1) : $t), true);

      array_push($lunarArray, $year, $m, $this->getCapitalNum($e, false));
    }

    array_push(
      $lunarArray,
      $this->getLunarYearName($year), // 天干地支
      $t,
      $e,
      $this->getYearZodiac($year), // 生肖
      $leapMonth // 閏幾月
    );

    return $lunarArray;
  }

  /**
   * 獲取數字的陰曆叫法.
   *
   * @param int  $num     數字
   * @param bool $isMonth 是否是月份的數字
   *
   * @return string the capital number
   */
  public function getCapitalNum(int $num, bool $isMonth = false): string
  {
    if ($isMonth) {
      return static::MONTH_HASH[$num];
    }

    if ($num <= 10) {
      $res = '初' . static::DATE_HASH[$num];
    } elseif ($num < 20) {
      $res = '十' . static::DATE_HASH[$num - 10];
    } elseif ($num === 20) {
      $res = '二十';
    } elseif ($num < 30) {
      $res = '廿' . static::DATE_HASH[$num - 20];
    } elseif ($num === 30) {
      $res = '三十';
    } else {
      $res = '';
    }

    return $res;
  }
}
