<?php
session_start();
require_once('app/api/connect.php');
require_once('app/api/mystore.php');
?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->

    <meta name="keywords" content="<?= $store->st_keywords ?>" />
    <meta name="description" content="<?= $store->st_description ?>" />
    <meta name="author" content="<?= $store->st_author ?>" />

    <title>นโยบายส่วนบุคคล | <?= $store->st_name ?></title>

    <?php require_once('layouts/head.php'); ?>
</head>

<body class="sub_page">

    <div class="hero_area">
        <!-- header section strats -->
        <?php require_once('layouts/menu.php'); ?>
        <!-- end header section -->
    </div>

    <!-- why us section -->

    <section class="why_us_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    นโยบายส่วนบุคคล
                </h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <p>
                        บริษัท อิมเม้นซ์ คอร์ปอเรชั่น จำกัด ให้ความสำคัญและส่งเสริมในการการคุ้มครองข้อมูลส่วนตัวของท่าน ความเป็นส่วนตัวของท่านมีความสำคัญต่อบริษัทอย่างมาก บริษัทจะเก็บรวบรวม บันทึก เผยแพร่และใช้งานเฉพาะข้อมูลที่ท่านให้ทางบริษัทโดยสมัครใจเท่านั้น หากท่านไม่ยอมรับหรือไม่เห็นด้วยกับข้อตกลงและเงื่อนไขภายใต้นโยบายความเป็นส่วนตัวนี้ กรุณาอย่าเข้าใช้แพลตฟอร์มของบริษัท รวมถึงการสมัครเป็นสมาชิก
                    </p>
                    <p>
                        บริษัทจะเก็บรวบรวมเฉพาะข้อมูลที่จำเป็นสำหรับบริษัทเพื่อที่จะให้บริการต่อท่าน บริษัทอาจขออนุญาติเก็บข้อมูลของท่านเพิ่มเติมเพื่อจุดประสงค์เช่น การพัฒนาการให้บริการของบริษัท หรือ การวิเคราะห์พฤติกรรมผู้บริโภค ทางบริษัทจะเก็บเฉพาะข้อมูลที่เกี่ยวข้องกับข้อตกลงที่ทางบริษัททำกับท่านเท่านั้น ทางบริษัทจะเก็บข้อมูลของท่านเป็นระยะเวลาตามที่กฎหมายกำหนด หรือตราบเท่าที่ข้อมูลยังมีความเกี่ยวข้องกับจุดประสงค์ของการเก็บข้อมูลนั้น
                    </p>
                    <p>
                        ท่านสามารถเยี่ยมชมและเปิดดูแพลตฟอร์มของบริษัทได้โดยไม่ต้องให้ข้อมูลส่วนตัวกับทางบริษัท ระหว่างที่ท่านเข้าเยี่ยมชมหรือเปิดดู ตัวตนของท่านจะไม่ถูกเปิดเผยต่อบริษัท ทางบริษัทจะไม่ทราบถึงตัวตนของท่านยกเว้นท่านจะลงทะเบียนและสมัครเป็นสมาชิกบนแพลตฟอร์มของบริษัท และเข้าสู่ระบบผ่านบัญชีของท่านสมาชิกเท่านั้น
                    </p>
                    <p>
                        <strong>1. การจัดเก็บข้อมูลส่วนบุคคล</strong>
                    </p>
                    <p class="ml-5">
                        เมื่อท่านได้สร้างบัญชีและสมัครสมาชิกกับทางบริษัท หรือเมื่อท่านให้ข้อมูลส่วนบุคคลของท่านกับทางบริษัทในช่องทางอื่น ทางบริษัทจะทำการจัดเก็บเฉพาะข้อมูลส่วนบุคคลที่จำเป็นของท่าน ซึ่งรวมถึงข้อมูลดังต่อไปนี้
                    <ul>
                        <li>ชื่อ-สกุล</li>
                        <li>ที่อยู่เพื่อจัดส่ง</li>
                        <li>อีเมล</li>
                        <li>หมายเลขโทรศัพท์</li>
                    </ul>
                    </p>
                    <p class="ml-5">
                        กรุณาให้ข้อมูลที่ถูกต้อง ครบถ้วนและเป็นความจริงแก่ทางบริษัทหรือตัวแทนบริษัทที่ได้รับอนุญาติ หากมีการเปลี่ยนแปลงเกี่ยวกับข้อมูลของท่าน กรุณาแก้ไขข้อมูลของท่านให้ตรงกับข้อมูลปัจจุบันที่ท่านใช้อยู่ ทางบริษัทขอสงวนสิทธิ์ในการร้องขอเอกสารใด ๆ เพื่อตรวจสอบความถูกต้องของข้อมูลที่ท่านได้ให้ไว้
                    </p>
                    <p class="ml-5">
                        บริษัทจะจัดเก็บเฉพาะข้อมูลที่ท่านให้กับทางบริษัทด้วยความสมัครใจเท่านั้น หากท่านเลือกที่จะไม่ให้ข้อมูลส่วนบุคคลของท่านกับทางบริษัท หรือ เลือกที่จะไม่อนุญาติให้ทางบริษัทใช้ข้อมูลส่วนบุคคลของท่านอีกต่อไปแล้ว อย่างไรก็ตามทางบริษัทอาจไม่สามารถให้บริการท่านได้อย่างเต็มที่เหมือนดังเดิม
                    </p>
                    <p class="ml-5">
                        ท่านสามารถเข้าถึงและแก้ไขข้อมูลของท่านได้ทุกเมื่อ หากท่านให้ข้อมูลของบุคคลอื่น ทางบริษัทถือว่าท่านได้รับอนุญาติจากจากบุคคลนั้นๆแล้วก่อนที่จะให้ข้อมูลเหล่านั้นกับทางบริษัท ทางบริษัทจะไม่รับผิดชอบหากท่านให้ข้อมูลส่วนบุคคลของผู้อื่นโดยไม่ได้อนุญาติจากเจ้าของที่แท้จริงของข้อมูลส่วนบุคคลนั้นๆ
                    </p>
                    <p class="ml-5">
                        หากท่านลงทะเบียนและสมัครสมาชิกกับทางบริษัทผ่านบัญชีโซเชียลมีเดียของท่าน หรือท่านได้เชื่อมบัญชีโซเชียลมีเดียของท่านเข้ากับบัญชีที่ท่านได้สร้างไว้กับทางบริษัท หรือ ท่านใช้บริการอื่นๆที่เกี่ยวข้องกับบัญชีโซเชียลมีเดียของ <?= $store->st_name ?> ทางบริษัทจะสามารถเข้าถึงข้อมูลส่วนบุคคลของท่านได้หากท่านเคยอนุญาติให้โซเชียลมีเดียนั้นเก็บข้อมูลและเข้าถึงข้อมูลของท่านได้
                    </p>
                    <p>
                        <strong>2. การใช้และการเปิดเผยข้อมูลส่วนบุคคล</strong>
                    </p>
                    <p class="ml-5">
                        ข้อมูลส่วนบุคคลของท่านที่บริษัทจัดเก็บจะถูกนำไปใช้ หรือแบ่งปันกับบุคคลภายนอก (ซึ่งรวมถึงบริษัทที่เกี่ยวข้อง ผู้ให้บริการภายนอก และผู้ขายที่เป็นบุคคลภายนอก) เพื่อจุดประสงค์ทั้งหมดหรือบางส่วนดังต่อไปนี้
                    <ul>
                        <li>เพื่ออำนวยความสะดวกให้กับท่านในการใช้บริการ</li>
                        <li>เพื่อดำเนินการเกี่ยวกับคำสั่งซื้อที่ท่านได้ส่งเข้ามาผ่านทางแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อดำเนินการชำระเงินสำหรับคำสั่งซื้อของท่านที่ได้สั่งเข้ามาผ่านทางแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อจัดส่งสินค้าที่ท่านได้สั่งซื้อผ่านทางแพลตฟอร์มของ <?= $store->st_name ?> (เราอาจส่งข้อมูลส่วนบุคคลของท่านให้กับบุคคลภายนอกเพื่อทำการจัดส่งสินค้าให้ท่าน)</li>
                        <li>เพื่อแจ้งสถานะการจัดส่งสินค้าของคำสั่งซื้อของท่าน</li>
                        <li>เพื่อใช้สำหรับการให้บริการที่เกี่ยวกับศูนย์บริการลูกค้า</li>
                        <li>เพื่อยืนยันข้อมูลของท่านกับผู้ให้บริการขนส่งสินค้าสำหรับคำสั่งซื้อของท่าน</li>
                        <li>เพื่อส่งข้อมูลเกี่ยวกับกิจกรรมทางการตลาด และโปรโมชั่นต่างๆ</li>
                        <li>เพื่อจัดการเกี่ยวกับธุรกรรมทางการเงินที่เกี่ยวข้องกับการชำระเงินของท่าน</li>
                        <li>เพื่อตรวจสอบข้อมูลบนแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อพัฒนาการใช้งานและเนื้อหาบนแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อเข้าใจมุมมองการใช้งานของท่านบนแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อศึกษาพฤติกรรมของผู้ใช้งานแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อให้ข้อมูลที่เป็นประโยชน์ต่อท่านเมื่อท่านใช้บริการบนแพลตฟอร์มของ <?= $store->st_name ?></li>
                        <li>เพื่อให้ข้อมูลเกี่ยวกับสินค้าและบริการของ <?= $store->st_name ?></li>
                    </ul>
                    </p>
                    <p class="ml-5">
                        * ท่านสามารถยกเลิกบริการประชาสัมพันธ์เกี่ยวกับกิจกรรมทางการตลาดและโปรโมชั่นต่างๆ ได้ทุกเมื่อ
                    </p>
                    <p class="ml-5">
                        นกรณียกเว้น ทางบริษัทอาจจำเป็นต้องเปิดเผยข้อมูลของท่าน หากทางบริษัทมีเหตุผลให้เชื่อว่าหากไม่เปิดเผยข้อมูลของท่าน ท่านอาจมีภัยคุกคามต่อชีวิตและสุขภาพได้ หรือ หากทางบริษัทต้องปฎิบัติตามการบังคับใช้ทางกฎหมายต่างๆ หรือเพื่อให้เป็นไปตามข้อกำหนดทางกฎเกณฑ์และกฏหมายและการร้องขอ
                    </p>
                    <p class="ml-5">
                        ทางบริษัทอาจแบ่งปันข้อมูลของท่านให้กับบุคคลภายนอก หรือ บริษัทที่เกี่ยวข้องเพื่อจุดประสงค์ข้างต้น โดยเฉพาะอย่างยิ่งเพื่อให้ธุรกรรมของท่านสำเร็จลุล่วง เพื่อบริหารจัดการบัญชี เพื่อทำการตลาดและเพื่อให้เป็นไปตามข้อกำหนดทางกฎเกณฑ์และกฎหมายและคำร้องขอตามที่ทางบริษัทเห็นว่าจำเป็น
                    </p>
                    <p class="ml-5">
                        ในการแบ่งปันข้อมูลส่วนบุคคลของท่าน เราจะพยายามอย่างยิ่งที่จะทำให้แน่ใจว่าบรรดาบุคคลภายนอกและผู้ที่เกี่ยวข้องนั้นจะเก็บข้อมูลส่วนบุคคลของท่านไว้อย่างปลอดภัยโดยปราศจากการเข้าถึง การจัดเก็บ การใช้ การเปิดเผย หรือการกระทำที่เป็นความเสี่ยงอย่างใด ๆ โดยไม่ได้รับอนุญาต และจะเก็บข้อมูลส่วนบุคคลของท่านไว้เพียงเท่าที่ข้อมูลส่วนบุคคลของท่านยังคงมีความจำเป็นต่อการบรรลุจุดประสงค์ข้างต้น
                    </p>
                    <p class="ml-5">
                        ในการดำเนินการพัฒนาธุรกิจ เราอาจต้องทำการขายหรือซื้อห้างร้าน สาขาย่อย หรือหน่วยธุรกิจต่าง ๆ ซึ่งในการทำธุรกรรมเหล่านี้ ข้อมูลของลูกค้าจึงถือเป็นสินทรัพย์ทางธุรกิจอย่างหนึ่งที่สามารถถ่ายโอนได้ แต่ยังคงอยู่ภายใต้คำมั่นสัญญาที่ให้ไว้ในนโยบายด้านความเป็นส่วนตัวที่มีมาแต่ก่อน เว้นแต่ในกรณีที่ลูกค้าได้ให้ความยินยอมเป็นอย่างอื่น นอกจากนี้ หากมีกรณีที่บริษัทหรือสินทรัพย์ทั้งหมดของบริษัท ถูกเข้าถือครอง ข้อมูลของลูกค้าก็ย่อมเป็นหนึ่งในสินทรัพย์ที่จะถูกถ่ายโอนไปด้วยเช่นกัน
                    </p>
                    <p>
                        <strong>3. สิทธิของบริษัทในการเปิดเผยข้อมูลส่วนบุคคล</strong>
                    </p>
                    <p class="ml-5">
                        ท่านยินยอมและอนุญาติให้บริษัทเปิดเผยข้อมูลส่วนบุคคลของท่านต่อหน่วยงานของรัฐที่ได้รับอนุญาติ หรือเจ้าของที่แท้จริงของข้อมูลส่วนบุคคลนั้นๆ หากทางบริษัทมีเหตุผลที่เชื่อถือได้ว่ามีความจำเป็นในการเปิดเผยข้อมูลส่วนบุคคลของท่านเพื่อปฎิบัติตามหน้าที่และความรับผิดชอบ รวมการจัดการ ทั้งด้วยความสมัครใจหรือความจำเป็น เพื่อให้ความร่วมมือแก่หน่วยงานของรัฐตามคำสั่ง หรือกระบวนการสืบสวนสอบสวนของรัฐ ท่านยอมรับและยืนยันว่าท่านจะไม่ทำการฟ้องร้องหรือร้องเรียน ต่อทางบริษัทในเรื่องที่เกี่ยวข้องกับการเปิดเผยข้อมูลส่วนบุคคลของท่าน
                    </p>
                    <p>
                        <strong>4. การถอนความยินยอม</strong>
                    </p>
                    <p class="ml-5">
                        ท่านอาจแสดงเจตจำนงที่จะคัดค้านไม่ให้เราใช้หรือเปิดเผยข้อมูลส่วนบุคคลของท่านอีกต่อไปไม่ว่าเพื่อจุดประสงค์ใด ๆ และไม่ว่าในกรณีใด ๆ ตามที่ระบุไว้ข้างต้น ได้ทุกเมื่อ กรุณาติดต่อบริษัทผ่านทาง <?= $store->st_email ?> เพื่อแสดงเจตจำนงของท่านในการยกเลิกความยินยอมของท่าน อย่างไรก็ตามหากท่านไม่อนุญาติให้ทางบริษัทใช้หรือเปิดเผยข้อมูลของท่าน ทางบริษัทอาจะไม่สามารถจัดหาสินค้าหรือบริการให้กับท่าน หรือไม่สามารถปฏิบัติตามสัญญาที่ได้ให้ไว้กับท่านอีกต่อไป ทั้งนี้ขึ้นอยู่กับลักษณะของคำคัดค้านของท่าน ทางบริษัทขอสงวนสิทธิโดยชัดแจ้งในการใช้สิทธิและการเยียวยาทางกฎหมายของเราในกรณีดังกล่าว
                    </p>
                    <p>
                        <strong>5. การแก้ไขข้อมูลส่วนตัวของท่าน</strong>
                    </p>
                    <p class="ml-5">
                        ท่านสามารถแก้ไขข้อมูลส่วนตัวของท่านให้สอดคล้องกับข้อมูลปัจจุบันของท่านได้ทุกเมื่อ โดยการเข้าไปที่หน้าบัญชีของท่านและแก้ไขข้อมูลต่างๆที่มีการเปลี่ยนแปลง กรุณาแก้ไขข้อมูลของท่านหากมีการเปลี่ยนแปลงใดๆ หากข้อมูลในหน้าบัญชีของท่านไม่ตรงกับข้อมูลปัจจุบันของท่าน อาจมีการล่าช้าในการส่งสินค้าที่ท่านสั่งซื้อ หรือ การล่าช้าอื่นๆในการบริการ
                    </p>
                    <p class="ml-5">
                        เราจะดำเนินการแบ่งปันการแก้ไขข้อมูลที่เกิดขึ้นกับข้อมูลของท่านให้กับบุคคลภายนอกและผู้ที่เกี่ยวข้องซึ่งเราได้แบ่งปันข้อมูลส่วนบุคคลของท่านไปแล้ว หากว่าข้อมูลส่วนบุคคลของท่านยังคงจำเป็นต่อจุดประสงค์ที่ระบุไว้ข้างต้น
                    </p>
                    <p>
                        <strong>6. การเข้าถึงข้อมูลส่วนบุคคลของท่าน</strong>
                    </p>
                    <p class="ml-5">
                        หากท่านต้องการดูข้อมูลส่วนบุคคลของท่านที่อยู่กับเรา หรือสอบถามเกี่ยวกับวิธีการที่ข้อมูลส่วนตัวของท่านได้ถูกนำไปใช้หรืออาจถูกนำไปใช้หรือถูกเปิดเผยโดยทางบริษัทภายในปีที่ผ่านมา กรุณาติดต่อเราผ่านทาง <?= $store->st_email ?> ทางบริษัทขอสงวนสิทธิ์ในการเรียกเก็บค่าธรรมเนียมที่เหมาะสมเพื่อเรียกดูข้อมูลส่วนตัวของท่านที่ถูกบันทึกไว้ และเพื่อความรวดเร็วในการดำเนินตามคำขอของท่านอาจมีความจำเป็นในการขอข้อมูลเพิ่มเติมตามคำขอของท่าน
                    </p>
                    <p>
                        <strong>7. ความปลอดภัยของข้อมูลส่วนบุคคลของท่าน</strong>
                    </p>
                    <p class="ml-5">
                        ทางบริษัทจัดเก็บข้อมูลทั้งหมดที่เก็บจากท่านไว้อย่างปลอดภัย เราจะคุ้มครองข้อมูลส่วนบุคคลของท่านโดย
                    <ul>
                        <li>จำกัดการเข้าถึงข้อมูลส่วนบุคคล</li>
                        <li>บำรุงรักษาเครื่องมือเครื่องใช้ทางเทคโนโลยี เพื่อป้องกันการเข้าถึงคอมพิวเตอร์โดยไม่ได้รับอนุญาต</li>
                        <li>ทำลายข้อมูลของท่านอย่างปลอดภัย เมื่อข้อมูลนั้นไม่มีความจำเป็นอีกต่อไปในทางกฎหมายหรือทางธุรกิจ</li>
                    </ul>
                    </p>
                    <p class="ml-5">
                        * รหัสผ่านของท่านจะเป็นเครื่องมือในการเข้าสู่บัญชีของท่าน กรุณาใช้ตัวเลข ตัวอักษร และสัญลักษณ์พิเศษอันมีลักษณะบ่งเฉพาะ และไม่แบ่งปันรหัสผ่านของท่านให้กับผู้ใด หากท่านแบ่งปันรหัสผ่านให้กับผู้อื่น ท่านจะต้องรับผิดชอบต่อการกระทำใด ๆ รวมทั้งบรรดาผลที่เกิดขึ้นภายใต้ชื่อบัญชีของท่าน หากท่านปล่อยให้รหัสผ่านของท่านเป็นที่ล่วงรู้ ท่านอาจไม่สามารถควบคุมข้อมูลส่วนบุคคล และข้อมูลอื่น ๆ ของท่านที่ให้ไว้กับทางบริษัท นอกจากนี้ท่านอาจจะต้องผูกพันภายใต้ข้อกฎหมายบางประการในนามของท่าน ดังนั้น หากรหัสผ่านของท่านมีความสุ่มเสี่ยงที่จะเป็นที่ล่วงรู้ ท่านควรติดต่อทางบริษัททันทีและทำการเปลี่ยนรหัสผ่านของท่าน ทางบริษัทขอเตือนว่าท่านจะต้องทำการออกจากระบบบัญชีของท่านและปิดโปรแกรมท่องอินเตอร์เน็ตทุกครั้งเมื่อท่านเสร็จสิ้นการใช้คอมพิวเตอร์สาธารณะ
                    </p>
                    <p>
                        <strong>8. ผู้เยาว์</strong>
                    </p>
                    <p class="ml-5">
                        สำหรับผู้เยาว์ภายใต้กฎหมายไทย ท่านต้องได้รับความยินยอมและเห็นชอบจากผู้ปกครองหรือผู้ดูแลของท่านก่อนการสมัครสมาชิกกับทางบริษัท หากท่านผู้เยาว์ได้สมัครสมาชิกกับทางบริษัทเรียบร้อยแล้ว ทางบริษัทจะถือว่าท่านได้รับความยินยอมและเห็นชอบจากผู้ปกครองหรือผู้ดูแลของท่านเรียบร้อยแล้ว ท่านยินยอมและยอมรับว่าทางบริษัทไม่ต้องรับผิดชอบใดๆ ต่อท่าน หากท่านไม่ได้รับความยินยอมและเห็นชอบจากผู้ปกครองหรือผู้ดูแลของท่านก่อนการสมัครสมาชิกของท่าน
                    </p>
                    <p>
                        <strong>9. การจัดเก็บข้อมูลคอมพิวเตอร์</strong>
                    </p>
                    <p class="ml-5">
                        ทางบริษัทหรือผู้ให้บริการที่ได้รับอนุญาตจากทางบริษัทอาจจะใช้คุ้กกี้ เว็บบีคอนส์ หรือ เทคโนโลยีอื่นใดในการเก็บข้อมูลเพื่อช่วยเหลือท่านให้สามารถใช้บริการและเข้าถึงการบริการได้ดีขึ้น เร็วขึ้น ปลอดภัยขึ้น และมีความเป็นส่วนบุคคลมากขึ้น
                    </p>
                    <p class="ml-5">
                        เมื่อท่านเข้าเยี่ยมชมแพลตฟอร์มของ <?= $store->st_name ?> เซอร์ฟเวอร์ของทางบริษัทจะบันทึกข้อมูลที่โปรแกรมท่องอินเตอร์เน็ตของท่านส่งเข้ามาโดยอัตโนมัติเมื่อใดก็ตามที่ท่านเข้าเยี่ยมชมเว็บไซต์ ซึ่งข้อมูลดังกล่าวนี้รวมถึง:
                    <ul>
                        <li>IP address ของคอมพิวเตอร์ของท่าน</li>
                        <li>ชนิดของโปรแกรมท่องอินเตอร์เน็ต </li>
                        <li>เว็บไซต์ที่ท่านเข้าเยี่ยมชมก่อนจะมาที่แพลตฟอร์มของทางบริษัท</li>
                        <li>หน้าเว็บที่ท่านเข้าเยี่ยมชมบนแพลตฟอร์มของบริษัท</li>
                        <li>เวลาที่ใช้ในการเยี่ยมหน้าเว็บนั้นๆ</li>
                        <li>ข้อมูลที่มีการค้นหาบนแพลตฟอร์มของทางบริษัท รวมถึง เวลาและวันที่ที่เข้าชม และข้อมูลทางสถิติอื่น ๆ</li>
                    </ul>
                    </p>
                    <p class="ml-5">
                        * ข้อมูลเหล่านี้จะถูกเก็บไว้เพื่อทำการวิเคราะห์และประเมิน เพื่อช่วยเราในการปรับปรุงแพลตฟอร์ม และการให้บริการ
                    </p>
                    <p class="ml-5">
                        คุ้กกี้ เป็นแฟ้มข้อมูลข้อความขนาดเล็ก โดยทั่วไปแล้วประกอบด้วยชุดตัวอักษรและชุดตัวเลข ที่ถูกเก็บไว้ในหน่วยความจำของโปรแกรมท่องเว็บไซต์หรืออุปกรณ์ของท่านเมื่อท่านเข้าเยี่ยมชมเว็บไซต์หรือดูข้อความใด ๆ โดยช่วยให้ทางบริษัทสามารถจดจำอุปกรณ์และโปรแกรมท่องเว็บไซต์เป็นการเฉพาะเจาะจง และช่วยให้ทงาบริษัทสามารถปรับเนื้อหาให้เข้ากับความสนใจของแต่ละบุคคลได้อย่างรวดเร็วยิ่งขึ้น และเพื่อช่วยให้ทางบริษัทสามารถจัดทำบริการและแพลตฟอร์ม ให้มีความสะดวกสบายและมีประโยชน์สำหรับท่านมากยิ่งขึ้น
                    </p>
                    <p class="ml-5">
                        เว็บบีคอนส์ เป็นรูปภาพขนาดเล็กที่อาจถูกรวมอยู่ในบริการและแพลตฟอร์มของทางบริษัท โดยจะช่วยให้ทางบริษัทสามารถนับจำนวนผู้ใช้ที่เข้ามาชมหน้าเว็บเหล่านี้ เพื่อที่ทางบริษัทจะสามารถเข้าใจถึงความชอบและความสนใจของท่านได้ดียิ่งขึ้น
                    </p>
                    <p>
                        <strong>10. สแปม สปายแวร์ หรือไวรัส</strong>
                    </p>
                    <p class="ml-5">
                        ทางบริษัทไม่อนุญาติให้มีการใช้ สแปม สปายแวร์ หรือ ไวรัส บนแพลตฟอร์มของบริษัท อีกทั้งบัญชีผู้ใช้หรือบัญชีผู้ขายรายทุกรายไม่ได้รับอนุญาติให้ติดต่อสื่อสารกันผ่านอีเมลหรือช่องทางการสื่อสารอื่นๆโดยไม่ได้รับความยินยอมและอนุญาติจากทั้งสองฝ่ายโดยชัดแจ้ง ดังนั้นทั้งผู้ขายและผู้ซื้อทุกท่านไม่ควรติดต่อสื่อสารกันบนแพลตลฟอร์มของ <?= $store->st_name ?> โดยมีการส่งสแปม สปายแวร์ หรือไวรัสคอมพิวเตอร์ให้กันและกัน หากท่านต้องการแจ้งเกี่ยวกับข้อความที่น่าสงสัย กรุณาติดต่อผ่าน <?= $store->st_email ?>
                    </p>
                    <p>
                        <strong>11. การเปลี่ยนแปลงนโยบายความเป็นส่วนตัว</strong>
                    </p>
                    <p class="ml-5">
                        ทางบริษัทจะทบทวนประสิทธิภาพของนโยบายความเป็นส่วนตัวอย่างสม่ำเสมอว่าเพียงพอหรือไม่ ทางบริษัทขอสงวนสิทธิ์ในการปรับปรุงและเปลี่ยนแปลงนโยบายความเป็นส่วนตัวนี้เมื่อใดก็ได้ การเปลี่ยนแปลงใด ๆ ที่เกิดขึ้นกับนโยบายนี้จะได้รับการเผยแพร่บนแพลตฟอร์มของบริษัท
                    </p>
                    <p>
                        <strong>12. การติดต่อ</strong>
                    </p>
                    <p class="ml-5">
                        หากท่านต้องติดต่อทางบริษัท ไม่ว่าจะเกี่ยวกับการเพิกถอนความยินยอมของท่านที่ให้ทางบริษัทใช้ข้อมูลส่วนบุคคลของท่าน หรือท่านต้องการเข้าถึงหรือแก้ไขข้อมูลส่วนบุคคลของท่าน หรือท่านมีข้อสงสัย ข้อติชมหรือข้อร้องเรียนใด ๆ หรือท่านต้องการความช่วยเหลือด้านเทคนิคหรือเรื่องที่เกี่ยวกับคุ้กกี้โปรดติดต่อเราที่ <?= $store->st_email ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- end why us section -->

    <?php require_once('layouts/footer.php'); ?>


</body>

</html>