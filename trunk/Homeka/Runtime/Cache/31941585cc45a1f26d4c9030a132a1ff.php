<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Index</title>
        <link href="Css/layout.css" rel="stylesheet" type="text/css" />
        <link href="Css/c_assist.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="Js/jquery.js">
        </script>
        <script type="text/javascript" src="Js/main.js">
        </script>
    </head>
    <body>
        <div id="header">
            <div class="header_bg">
                <div class="header_logo">
                    <img src=""/>
                </div>
                <div class="header_link">
                    <a href="" class="white">Home Page</a>
                    |<a href="white" class="white">Set Home</a>
                    |<a href="white" class="white"> Favorite</a>
                </div>
            </div>
        </div>
        <div class="top_nav">
            <div class="map">
                <a title="Site Map" href="docc/map.php"><img width="86" height="21" src="Images/btn_map.gif"></a>
            </div>
            <ul class="dropdown">
                <li>
                    <a href="#" class="alive"><span>Home</span></a>
                </li>
                <li>
                    <a href="#"><span>Products</span></a>
                    <ul class="sub_menu">
                        <li>
                            <a href="#">Artificial Turf</a>
                        </li>
                        <li>
                            <a href="#">Batting Cages</a>
                            <ul>
                                <li>
                                    <a href="#">Indoor</a>
                                </li>
                                <li>
                                    <a href="#">Indoor</a>
                                </li>
                                <li>
                                    <a href="#">Indoor</a>
                                </li>
                                <li>
                                    <a href="#">Indoor</a>
                                </li>
                                <li>
                                    <a href="#">Indoor</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Benches &amp; Bleachers</a>
                        </li>
                        <li>
                            <a href="#">Communication Devices</a>
                        </li>
                        <li>
                            <a href="#">Dugouts</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><span>About Us</span></a>
                </li>
                <li>
                    <a href="#"><span>Quality Guarantee</span></a>
                </li>
                <li>
                    <a href="#"><span>Market Area</span></a>
                </li>
                <li>
                    <a href="#"><span>Contact Us</span></a>
                </li>
            </ul>
        </div>
        <script>
            $(function(){
                $("ul.dropdown li").hover(function(){
                    $(this).addClass("hover");
                    $('ul:first', this).css('visibility', 'visible');
                }, function(){
                    $(this).removeClass("hover");
                    $('ul:first', this).css('visibility', 'hidden');
                });
                $("ul.dropdown li ul li:has(ul)").find("a:first").append(" &raquo; ");
            });
        </script>
        <div id="slide_box">
            <div id=imgPlay>
                <UL class=imgs id=actor>
                    <LI>
                        <A href="#" target=_blank><IMG title=板长寿司2010罗志祥舞法舞天北京演唱会 src="Images/Slide/01.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                    <LI>
                        <A href="#" target=_blank><IMG title=张学友2011巡回演唱会北京站 src="Images/Slide/02.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                    <LI>
                        <A href="#" target=_blank><IMG title=爱无止境Air Supply空气补给站北京演唱会 src="Images/Slide/03.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                    <LI>
                        <A href="#" target=_blank><IMG title=2010迈克学摇滚中国巡演北京演唱会 src="Images/Slide/04.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                    <LI>
                        <A href="#" target=_blank><IMG title=2010张杰北京演唱会 src="Images/Slide/05.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                    <LI>
                        <A href="#" target=_blank><IMG title=海上良宵”蔡琴2010北京演唱会 src="Images/Slide/06.jpg"></A>
                        <div class=btn>
                            <A title=立即购买 href="#" target=_blank>立即购买</A>
                        </div>
                    </LI>
                </UL>
                <div class=num>
                    <P class=lc>
                    </P>
                    <P class=mc>
                    </P>
                    <P class=rc>
                    </P>
                </div>
                <div class="num"id=numInner>
                </div>
                <div class="prev png">
                    上一张
                </div>
                <div class="next png">
                    下一张
                </div>
            </div>
        </div>
        <script type="text/javascript">
            pngHandler.init();
        </script>
        <div class="search_box mb">
            <div class="left">
                <form id="form1" name="form1" method="get" action="docc/products_search.php">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>
                                    <strong class="font_black">Products:&nbsp;</strong>
                                </td>
                                <td>
                                    <input name="textfield" class="input1" id="textfield" type="text">&nbsp;&nbsp;
                                </td>
                                <td>
                                    <input name="submit" value="Search" height="18" type="submit" width="64">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="right1">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                <strong class="blue">Talk to Us Now:&nbsp;&nbsp;&nbsp;&nbsp;</strong>
                            </td>
                            <td>
                                <a href="msnim_3achat@contact=fubei_0226_40hotmail.com"><img src="images/btn_msn.gif" class="btn1" height="21" width="76"></a><a href="callto_3a/acemade.juniss"><img src="images/btn_skype.gif" class="btn1" height="21" width="76"></a>
                            </td>
                            <td>
                                <a href="#" class="phone"><span>+86-574-87369417</span></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end header-->
        <div id="content">
            <div class="content_l fl w200 mh350">
                <div class="menu_l">
                    <div class="title">
                        Products Class
                    </div>
                    <ul>
                        <li>
                            <a href="#"><strong>Magnet Material</strong></a>
                            <ul>
                                <li>
                                    <a href="sub_product_info.php@id=28.htm" class="on">Sintered NdFeB Magnet</a>
                                </li>
                                <li>
                                    <a href="sub_product_info.php@id=20.htm">Sintered Ferrite Magnet</a>
                                </li>
                                <li>
                                    <a href="sub_product_info.php@id=19.htm">Flexible Magnet</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><strong>Magnet Applications</strong></a>
                            <ul>
                                <li>
                                    <a href="sub_product_info.php@id=21.htm">Permanent Magnetic Lift</a>
                                </li>
                                <li>
                                    <a href="sub_product_info.php@id=22.htm">Permanent Magnetic Chuck</a>
                                </li>
                                <li>
                                    <a href="sub_product_info.php@id=31.htm">Speaker Parts</a>
                                </li>
                                <li>
                                    <a href="sub_product_info.php@id=24.htm">Wind Power Generators</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <br>
                    <br>
                    <br>
                    <div class="title1">
                        Technical
                    </div>
                    <ul>
                        <li>
                            <a href="faqs.php.htm">FAQs</a>
                        </li>
                        <li>
                            <a href="testing.php.htm">Magnet Testing</a>
                        </li>
                        <li>
                            <a href="download.php.htm">Tech Data Download</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="content_r fr w770 mh350">
                <div class="flbox">
                    <img width="365px" height="160px" src="images/pic_about1.jpg">
                    <br>
                    <span class="blue">About Us</span>
                    <p>
                        Acemade Group Ltd designs and manufactures high performance industrial magnets and magnetic assemblies. Our product line in...Acemade Group Ltd designs and manufactures high performance industrial magnets and magnetic assemblies. Our product line in..Acemade Group Ltd designs and manufactures high performance industrial magnets and magnetic assemblies. Our product line agnetic assemblies. Our product line 
                    </p>
                    <div class="more">
                        <a href="docc/qg.php.htm"><img src="images/btn_more1.gif" alt="view more" height="18" width="85"></a>
                    </div>
                </div>
                <div class="flbox">
                    <img src="images/pic_04.jpg" width="365px" height="160px">
                    <br>
                    <span class="blue">Quality Guarantee</span>
                    <p>
                        The aim we are pursuing is&nbsp; "zero-complaint" every order.For this purpose, we make sure every step is right and perfect in manufactoring.
                        &nbsp;&nbsp; All the production is under I...The aim we are pursuing is&nbsp; "zero-complaint" every order.For this purpose, we make sure every step is right and perfect in manufactoring.every order.For this purpose, we make sure every step is right and perfect in manufactoring.
                    </p>
                    <div class="more">
                        <a href="docc/qg.php.htm"><img src="images/btn_more1.gif" alt="view more" height="18" width="85"></a>
                    </div>
                </div>
                <div class="clearfix">
                </div>
                <div class="mt w770">
                    <div class="pro_nav">
                        Products
                    </div>
                    <div class="pro_relas w750">
                        <ul>
                            <li>
                                <div class="th">
                                    <a href="" target="_blank"><img src="Images/demo/1.jpg" height="146" width="146" alt="Arc Magnet for Liner Motor"></a>
                                </div><h3><a href="" target="_blank">Arc Magnet for Liner Motor</a></h3>
                            </li>
                            <li>
                                <div class="th">
                                    <a href="" target="_blank"><img src="Images/demo/1.jpg" height="146" width="146" alt="Arc Magnet for Liner Motor"></a>
                                </div><h3><a href="" target="_blank">Arc Magnet for Liner Motor</a></h3>
                            </li>
                            <li>
                                <div class="th">
                                    <a href="" target="_blank"><img src="Images/demo/1.jpg" height="146" width="146" alt="Arc Magnet for Liner Motor"></a>
                                </div><h3><a href="" target="_blank">Arc Magnet for Liner Motor</a></h3>
                            </li>
                            <li>
                                <div class="th">
                                    <a href="" target="_blank"><img src="Images/demo/1.jpg" height="146" width="146" alt="Arc Magnet for Liner Motor"></a>
                                </div><h3><a href="" target="_blank">Arc Magnet for Liner Motor</a></h3>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix" style="width:100%">
            </div>
            <div class="main_contact clearfix">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                        <tr>
                            <td width="28%">
                                <strong>CorpName : </strong>Acemade Group Co., Ltd. 
                                <br>
                                <strong>Address : </strong>5th FL.,137 Zhongshan Rd.(E.) 
                            </td>
                            <td width="13%">
                                <strong>Name : </strong>Juniss Fu 
                                <br>
                                <strong>Zip : </strong>315000
                            </td>
                            <td width="24%">
                                <strong>Tel : </strong>+86(574)87369417  87026256 
                                <br>
                                <strong>Fax : </strong>+86(574)87344602 
                            </td>
                            <td width="35%">
                                <strong>E-mail :</strong>&nbsp;<a href="mailto:">sales04@acemadesales.com</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:">magnetech@vip.163.com</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--end content-->
        <div class="hr">
        </div>
        <div id="footer">
            <p class="link mt">
                <a href="../index.php">Home</a>
                |<a href="../docc/products.php">Products</a>
                |<a href="../docc/about.php"> About Us</a>
                |<a href="../docc/qg.php">Quality Guarantee </a>|<a href="../docc/faqs.php"> Technical Information</a>
                | <a href="../docc/market.php">Market Area</a>
                |<a href="../docc/contact.php"> Contact Us</a>
                | <a href="../docc/quote.php">Request a Quote</a>
                | <a href="../docc/map.php">Site Map</a>
                |<a href="http://www.acemadegroup.com/">Acemade</a>
                | <a href="http://www.opticalfiber-tel.com/">Fiber Optic Patch Cord</a>
            </p>
            <p class="copyright">
                <strong>CopyRight © 2009 Acemade Group LTD. All rights reserved. ICP:07033233 .</strong>
            </p>
            <!--end youqinglink-->
        </div>
        <!--end footer-->
    </body>
</html>