<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Работа с данными php</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="Description" content="Enter your description here" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
<pre>
<?php
$example_persons_array = [
  [
      'fullname' => 'Иванов Иван Иванович',
      'job' => 'tester',
  ],
  [
      'fullname' => 'Степанова Наталья Степановна',
      'job' => 'frontend-developer',
  ],
  [
      'fullname' => 'Пащенко Владимир Александрович',
      'job' => 'analyst',
  ],
  [
      'fullname' => 'Громов Александр Иванович',
      'job' => 'fullstack-developer',
  ],
  [
      'fullname' => 'Славин Семён Сергеевич',
      'job' => 'analyst',
  ],
  [
      'fullname' => 'Цой Владимир Антонович',
      'job' => 'frontend-developer',
  ],
  [
      'fullname' => 'Быстрая Юлия Сергеевна',
      'job' => 'PR-manager',
  ],
  [
      'fullname' => 'Шматко Антонина Сергеевна',
      'job' => 'HR-manager',
  ],
  [
      'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
      'job' => 'analyst',
  ],
  [
      'fullname' => 'Бардо Жаклин Фёдоровна',
      'job' => 'android-developer',
  ],
  [
      'fullname' => 'Шварцнегер Арнольд Густавович',
      'job' => 'babysitter',
  ],
];

function getFullnameFromParts ($surname, $name, $patronomyc) {
return  ( $surname . ' '. $name . ' ' . $patronomyc) ;
}
function getPartsFromFullname ($string_data){
$array_maket =['surname', 'name', 'patronomyc'];
$array_datain = explode(' ', $string_data);
$array_dataout = array_combine($array_maket,$array_datain);

return ($array_dataout);
}

function getShortName($string_data){
$getShortNameperstr= getPartsFromFullname ($string_data)['name'].' '. mb_substr(getPartsFromFullname ($string_data)['surname'],0,1 ) . '.';
return $getShortNameperstr;
}

function getGenderFromName ($string_data){
  $sumgender = 0;
 
if ((mb_substr(getPartsFromFullname ($string_data)['surname'],-1,1))==='в') {
  $sumgender = $sumgender + 1;  
 } 
if((mb_substr(getPartsFromFullname ($string_data)['surname'],-2,2))==='ва') {
  $sumgender = $sumgender - 1;
  }
if ((mb_substr(getPartsFromFullname ($string_data)['name'],-1,1))==='а') {
    $sumgender = $sumgender - 1;
    } 
if ((mb_substr(getPartsFromFullname ($string_data)['name'],-1,1))==='й'||(mb_substr(getPartsFromFullname ($string_data)['name'],-1,1))==='н') {
  $sumgender = $sumgender + 1;  
  }

if ((mb_substr(getPartsFromFullname ($string_data)['patronomyc'],-2,2))==='ич') {
  $sumgender = $sumgender + 1;  
  }
if((mb_substr(getPartsFromFullname ($string_data)['patronomyc'],-3,3))==='вна') {
  $sumgender = $sumgender - 1;
  };
  $equal=$sumgender <=> 0;
  if($equal === 1){
  return 'мужской пол';
 } else if ($equal===-1){
  return 'женский пол';
 }else if($equal===0){
  return 'неопределенный пол';
}

}
function getGenderDescription($example_persons_array){    
    $array_male = array_filter($example_persons_array, function ($example_persons_array){
         
      return (getGenderFromName ($example_persons_array['fullname']) ==='мужской пол');
    
    });
    $array_female = array_filter($example_persons_array, function ($example_persons_array){
         
      return (getGenderFromName ($example_persons_array['fullname']) ==='женский пол');
    
    });
    $array_unknow = array_filter($example_persons_array, function ($example_persons_array){
         
      return (getGenderFromName ($example_persons_array['fullname']) ==='неопределенный пол');
    
    });

$partMale = round(((count($array_male)) / (count($example_persons_array)))* 100,1 );
$partFemale = round((count($array_female) / count($example_persons_array)) * 100,1);
$partUnknow = round((count($array_unknow) / count($example_persons_array)) * 100,1);

echo <<<HEREDOCLETTER
Гендерный состав аудитории:
--------------------------- 
Мужчины - $partMale %
Женщины - $partFemale %
Не удалось определить - $partUnknow %
HEREDOCLETTER;
}

function getPerfectPartner($surname, $name, $patronomyc, $example_persons_array){
  
$string_data = getFullnameFromParts (mb_convert_case($surname, MB_CASE_TITLE_SIMPLE), mb_convert_case($name, MB_CASE_TITLE_SIMPLE), mb_convert_case($patronomyc, MB_CASE_TITLE_SIMPLE));

 $gender1 = getGenderFromName ($string_data);
 $randName = $example_persons_array[rand(0,count($example_persons_array)-1)]['fullname'];
while(getGenderFromName ($randName)===$gender1||getGenderFromName ($randName)==='неопределенный пол') {
  $randName = $example_persons_array[rand(0,count($example_persons_array)-1)]['fullname'];
}
$ShortName1 = getShortName($string_data);
$ShortName2 = getShortName($randName);
$chance = rand(50,99) + rand(0,99)/100 ;
$chance = number_format($chance, 2, '.', '');
echo <<<HEREDOCLETTER
$ShortName1 + $ShortName2 =
&hearts; Идеально на $chance % &hearts; 
HEREDOCLETTER;

}
?>
<div>
  <?php
getGenderDescription($example_persons_array);
echo "\n";
getPerfectPartner('иванова', 'ИВАННА', 'ВаСиЛьеВнА', $example_persons_array);
?>
</div>
</body>
</html>