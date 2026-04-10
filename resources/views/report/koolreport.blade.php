<?php
    use \koolreport\widgets\google\ColumnChart;
    use \koolreport\widgets\google\PieChart;
    use \koolreport\widgets\google\DonutChart;
    use \koolreport\charttable\ChartTable;
    use \koolreport\widgets\koolphp\Table;
?>
<html>
    <head>
        <title>KoolReport's Widgets</title>
    </head>
    <body>
    <body>
        <?php 
        ColumnChart::create(array(
            "dataSource"=>DB::table('sales')
                            ->join('customers','customers.id','sales.CustomerId')
                            ->select('customers.Name', DB::raw('SUM(GrandTotal) as total_sales'))
                            ->groupBy('customers.Name')
                            ->havingRaw('SUM(SubTotal) > ?', [1])
                            ->get()
        ));
        ?>
    </body>
</html>