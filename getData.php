<?php

require_once 'scripts/dbconfig.php';
header('Content-Type: application/json');

$fetch = $_GET['fetch'];
$fetch_id = $_GET['fetch_id'];
$fetch_id_2 = @$_GET['fetch_id_2'];

function fetchPriceData($item_id)
{
    try {
        $client = new BakeryDBClient;
        $menuItem = $client->getMenuItem($item_id);
        return $menuItem['item_price'];
    } catch (Exception $ex) {
        print_r($ex);
    }
}

function fetchStockStatus($item_id)
{
    try {
        $client = new BakeryDBClient;
        $data = $client->getStockSoldOverOrders($item_id);

        return [
            'TotalSales' => $data['TotalSales'] ?? 0,
            'TotalQty' => $data['TotalQty'] ?? 0,
            'ItemPrice' => round($data['ItemPrice'])
        ];
    } catch (Exception $ex) {
        print_r($ex);
    }
}

function fetchStockCalculations($item_id, $total_stock)
{
    try {
        $stockStatus = fetchStockStatus($item_id);

        $stockUtilization = ($stockStatus['TotalQty'] / $total_stock) * 100;
        $reorderRecommendation = ($stockStatus['TotalQty'] < $total_stock / 2) ? 'Yes' : 'No';
        $salesVelocity = ($stockStatus['TotalQty'] > 0) ? $stockStatus['TotalSales'] / $stockStatus['TotalQty'] : 0;

        // Prepare data for JSON response
        $response = [
            'totalSales' => $stockStatus['TotalSales'],
            'totalQty' => $stockStatus['TotalQty'],
            'stockUtilization' => $stockUtilization,
            'reorderRecommendation' => $reorderRecommendation,
            'salesVelocity' => $salesVelocity
        ];

        return json_encode($response);
    } catch (Exception $ex) {
        print_r($ex);
    }
}

switch ($fetch) {
    case 'menu_item_price':
        echo json_encode([
            'data' => fetchPriceData($fetch_id)
        ]);
        break;
    case 'stock_status':
        echo json_encode(fetchStockStatus($fetch_id));
        break;
    case 'stock_calculations':
        echo json_encode(fetchStockCalculations($fetch_id, $fetch_id_2));
        break;

    default:
        echo json_encode([
            'message' => 'Invalid selection. Please try again...'
        ]);
}
