<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
table, th, td {
  border: 1px solid;
  text-align: center;
  width: 100%;
}
td:nth-child(5),th:nth-child(5){
    border-right: none;
}
th{
    border-top: none;
}
td,tr,th{
    /* border-right: none; */
    border-left: none;
    border-bottom: none;
    margin: 0px 10px;
}
.summary td{
    border:none;
    border-top: 1px solid;
}
.page-break {
    page-break-after: always;
}
</style>
</head>
<body>
    <table>
        <tr>
          <th>Product</th>
          <th>Category</th>
          <th>Price</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
        @if ($products->count()>0)
        @foreach ($products as $sold)
        <tr>
          <td>{{ $sold['product_name']}}</td>
          <td>{{ $sold['category_name'] }}</td>
          <td>{{number_format($sold['price'],2) }}</td>
          <td>{{ date('M d, Y',strtotime($sold['created_at'])) }}</td>
          <td>{{ ucfirst($sold['status']) }}</td>
        </tr>
        @endforeach
        <tr class="summary">
            <td></td>
            <td>Overall</td>
            <td colspan="1">{{ number_format($summaries,2) }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="summary">
            <td></td>
            <td>Refund</td>
            <td colspan="1">- {{ number_format($totalrefund,2) }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="summary">
            <td></td>
            <td>Cancelled</td>
            <td colspan="1">- {{ number_format($totalcancel,2) }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="summary">
            <td></td>
            <td>Delivered</td>
            <td colspan="1">{{ number_format($totaldeliver,2) }}</td>
            <td></td>
            <td></td>
        </tr>
        <tr class="summary">
            <td></td>
            <td>Total</td>
            <td colspan="1">{{ number_format($totalsummaries,2) }}</td>
            <td>{{ date('M Y',strtotime($sold['created_at'])) }}</td>
            <td></td>
        </tr>
        @endif
      </table>
</body>
</html>
