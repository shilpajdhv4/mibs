<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<table border="1">
    <tr> 
        <th>Name</th>
        <th>MiddleName</th>
        <th>LastName</th>
        <th>Add_1</th>
        <th>ADD_2</th>
        <th>MOBILENO</th>
        <th>ALTmobileNO</th>
        <th>EMAILID</th>
        <th>MODEL</th>
        <th>COLOR</th>
        <th>MAKE</th>
        <th>BOOKINGDATE</th>
        <th>BOOKINGAMOUNT</th>
        <th>SaleDate</th>
        <th>DeliveryDate</th>
        <th>FINANCIERNAME</th>
        <th>REMAININGAMOUNT</th>
        <th>GENDER_1</th>
        <th>City_1</th>
        <th>STATE_1</th>
        <th>ACTIVITY</th>
        <th>LANDMARK</th>
        <th>followup1</th>
        <th>followup2</th>
        <th>followup3</th>
        <th>followup4</th>
        <th>FinalSRRemark</th>
    </tr>
        @foreach($download_data as $data)
        <tr>
            <td>{{$data->prospect_name}}</td>
            <td>{{$data->middle_name}}</td>
            <td>{{$data->last_name}}</td>
            <td>{{$data->add_1}}</td>
            <td>{{$data->add_2}}</td>
            <td>{{$data->mobile_no}}</td>
            <td>{{$data->almobile_no}}</td>
            <td>{{$data->email_id}}</td>
            <td>{{$data->model_name}}</td>
            <td>{{$data->color}}</td>
            <td>{{$data->make}}</td>
            <td>{{$data->enquiry_date}}</td>
            <td>{{$data->booking_amount}}</td>
            <td>{{$data->saledate}}</td>
            <td>{{$data->delivery_date}}</td>
            <td>{{$data->financer_name}}</td>
            <td>{{$data->remaining_amount}}</td>
            <td>{{$data->gender}}</td>
            <td>{{$data->dealer_location}}</td>
            <td>{{$data->state}}</td>
            <td>{{$data->activity}}</td>
            <td>{{$data->landmark}}</td>
            <td>{{$data->followup1}}</td>
            <td>{{$data->followup2}}</td>
            <td>{{$data->followup3}}</td>
            <td>{{$data->followup4}}</td>
            <td>{{$data->final_sr_remark}}</td>
        </tr>
        @endforeach
        
    </table>
<!------------------- Print Total Report Data End------------------->
<!------------------- Print Data Into Excel Sheet ------------------->
    <?php
//        echo "<pre>";print_r($_SERVER );
//        exit;
    $the_data = 'this is test text for downloading the contents.';
    $report_name = "Process-parameter-report";
    header("Content-Type: application/xls");
    header("Content-type: image/Upload");
    header("Content-Disposition: attachment; filename='.$report_name.xls");
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Transfer-Encoding: binary');
//} 
//else {
//    $flg = 1;
//    echo '<a href="javascript:void(0)" onclick="goToURL(); return false;">Go To URL</a>';
//}
?>

