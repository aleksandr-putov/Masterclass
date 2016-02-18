<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <title><?= $view['title'] ?></title>
            <script src="/js/jquery.min.js"></script>
            <script src="/js/bootstrap.min.js"></script>
            <link href="/css/bootstrap.min.css" rel="stylesheet">
                <link href="/css/styles.css" rel="stylesheet">		
                    </head>

                    <body>
                        <div class="container-fluid">
                        <div class = "row">

                                        <div class="col-md-12 header text-right">

                                        <img src="/img/logo.svg"  class="img-responsive" style="float: left; height: 120px">

                                            <h1><b>Мастер-класс по программированию</b></h1>

                                            <h4><b>Кафедра информатики, математического и компьютерного моделирования</b></h4>
                                            <!--<h2><b><?= $view['title'] ?></b></h2>--!>
                                            <p>"Нет никого, кто любил бы боль саму по себе, кто искал бы её и кто хотел бы иметь её просто потому, что это боль.."</p>

                                        </div>
                                    </div>
                        </div>
                        <div class="row">
                                        <div class="col-md-12 menu">
                                            <?= $view['menu'] ?>
                                        </div>
                                    </div>
                            <div class="row">
                                <div class = "col-md-2 backtap"></div>
                                <div class = "col-md-8 fronttap">
                                    
                                    
                                    <div class="row content">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-10">
                                            <?php include $view['content'] ?>						
                                        </div>
                                        <div class="col-md-1"></div>
                                    </div>
                                    <div class="row ">
                                        <div class="footer text-muted text-center">
                                            Created by Васян 2015
                                        </div>
                                    </div>


                                    <div class = "col-md-2 backtap"></div>
                                </div>
                            </div>
                        </div>

                    </body>
                    </html>