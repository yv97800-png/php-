\<?php

class Employee{
    private $name;
    private $depardtment;
    private $salary;
    private $photo;
    private $phone;
    private $shift;
    private $startDate;

    public function setName($name){
        $this->name= $name;
    }
    ///////
    public function setDepardtment($depardtment){
        $this->depardtment= $depardtment;
    }
    ///////
    public function setSalary ($salary){
        $this->salary= $salary;
    }
    ///////
    public function setPhoto($photo){        // ชื่อไฟล์รูป เช่น images/prae.jpg
        $this->photo= $photo;
    }
    ///////
    public function setPhone($phone){
        $this->phone= $phone;
    }
    ///////
    public function setShift($shift){        // กะทำงาน
        $this->shift= $shift;
    }
    ///////
    public function setStartDate($startDate){ // รูปแบบ ปี-เดือน-วัน เช่น 2024-03-01
        $this->startDate= $startDate;
    }

    // คำนวณอายุงาน
    private function getWorkTime(){
        $diff = (new DateTime($this->startDate))->diff(new DateTime());
        if ($diff->y > 0) {
            return $diff->y . " ปี " . $diff->m . " เดือน";
        }
        return $diff->m . " เดือน";
    }

    // แปลงวันที่เป็น วัน/เดือน/ปี พ.ศ.
    private function getThaiDate(){
        $d = new DateTime($this->startDate);
        return $d->format("d/m/") . ($d->format("Y") + 543);
    }

    // ถ้ามีรูปและไฟล์มีอยู่จริงจะแสดงรูป ถ้าไม่มีจะแสดงตัวอักษรแรกของชื่อ
    private function showPhoto(){
        if ($this->photo && file_exists(__DIR__ . "/" . $this->photo)) {
            echo "<img class='photo' src='" . htmlspecialchars($this->photo) . "' alt='" . htmlspecialchars($this->name) . "'>";
        } else {
            echo "<div class='photo avatar'>" . htmlspecialchars(mb_substr($this->name, 0, 1)) . "</div>";
        }
    }
    ////
    public function showData(){
        echo "<div class='card'>";

        $this->showPhoto();

        echo "<div class='info'>";
        echo "<div class='top'>";
        echo "<div>";
        echo "<div class='name'>" . htmlspecialchars($this->name) . "</div>";
        echo "<div class='role'><span class='role-label'>ตำแหน่ง</span><span class='badge'>" . htmlspecialchars($this->depardtment) . "</span></div>";
        echo "</div>";
        echo "<div class='salary'>" . number_format((float)$this->salary) . "<small> บาท</small></div>";
        echo "</div>";

        echo "<div class='details'>";
        echo "<div><span>เบอร์โทร</span>" . htmlspecialchars($this->phone) . "</div>";
        echo "<div><span>กะทำงาน</span>" . htmlspecialchars($this->shift) . "</div>";
        echo "<div><span>เริ่มงาน</span>" . $this->getThaiDate() . "</div>";
        echo "<div><span>อายุงาน</span>" . $this->getWorkTime() . "</div>";
        echo "</div>";

        echo "</div>";
        echo "</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>รายชื่อพนักงานคาเฟ่</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Sarabun", "Noto Sans Thai", sans-serif;
            background: #f5efe9;
            color: #3b2a20;
        }
        .wrap { max-width: 640px; margin: 0 auto; padding: 32px 16px; }
        h1 { margin: 0 0 4px; font-size: 26px; }
        .sub { margin: 0 0 24px; color: #7a6558; }

        .card {
            display: flex;
            gap: 18px;
            background: #fff;
            padding: 18px 20px;
            margin-bottom: 14px;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
        .photo {
            width: 88px;
            height: 88px;
            flex-shrink: 0;
            border-radius: 14px;
            object-fit: cover;
        }
        .avatar {
            background: #6f4e37;
            color: #fff;
            font-size: 34px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .info { flex: 1; min-width: 0; }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
                 //////////ส่วนของชื่อตำแหน่ง
        .name { font-size: 20px; font-weight: 600; margin-bottom: 4px; }
        .role { display: flex; align-items: center; gap: 8px; }
        .role-label { font-size: 16px; color: #2b1405; }
        .badge {
            display: inline-block;
            padding: 2px 12px;
            border-radius: 999px;
            background: #633314;
            color: #fffcfa;
            font-size: 14px;
        }
        .salary { font-size: 20px; font-weight: 600; color: #6f4e37; white-space: nowrap; }
        .salary small { font-size: 13px; font-weight: 400; color: #7a6558; }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 16px;
            margin-top: 14px;
            padding-top: 14px;
            border-top: 1px solid #eee3da;
            font-size: 15px;
        }
        .details span {
            display: block;
            font-size: 12px;
            color: #7a6558;
        }

        @media (max-width: 480px) {
            .card { flex-direction: column; }
        }
    </style>
</head>
<body>
<div class="wrap">
    <h1>☕ พนักงานคาเฟ่</h1>
    <p class="sub">รายชื่อพนักงานและรายละเอียด</p>

<?php
$emp1 = new Employee();
$emp1->setName("นายอนุวัมน์ ยะโก๊ะ");
$emp1->setDepardtment("ผู้จัดการ");
$emp1->setSalary("15000");
$emp1->setPhoto("images/prae.jpg");
$emp1->setPhone("081-234-5678");
$emp1->setShift("08:00 - 16:00");
$emp1->setStartDate("2024-03-01");
$emp1->showData();

$emp2 = new Employee();
$emp2->setName("ภูมิ");
$emp2->setDepardtment("บาริสต้า");
$emp2->setSalary("12000");
$emp2->setPhoto("images/phum.jpg");
$emp2->setPhone("089-876-5432");
$emp2->setShift("10:00 - 18:00");
$emp2->setStartDate("2025-06-15");
$emp2->showData();

$emp3 = new Employee();
$emp3->setName("โบ๊ท");
$emp3->setDepardtment("เด็กเสิร์ฟ");
$emp3->setSalary("12000");
$emp3->setPhoto("3.jpg");
$emp3->setPhone("086-111-2233");
$emp3->setShift("12:00 - 20:00");
$emp3->setStartDate("2026-01-10");
$emp3->showData();

$emp4 = new Employee();
$emp4->setName("โบ๊ท");
$emp4->setDepardtment("เด็กเสิร์ฟ");
$emp4->setSalary("12000");
$emp4->setPhoto("3.jpg");
$emp4->setPhone("086-111-2233");
$emp4->setShift("12:00 - 20:00");
$emp4->setStartDate("2026-01-10");
$emp4->showData();
?>

</div>
</body>
</html>