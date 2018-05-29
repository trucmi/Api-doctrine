<?php
/**
 * Created by PhpStorm.
 * User: rototo
 * Date: 14/02/2018
 * Time: 19:56
 */

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// create_product.php <name>
require_once "../bootstrap.php";


/*echo "<pre>";*/
// init du repo
$repository = $entityManager->getRepository('Tvtruc\Entities\Serie');
/*$repositoryTwo = $entityManager->getRepository('Tvtruc\Entities\Episode');*/

// set ID property of product to be edited
$search = isset($_GET['name']) ? $_GET['name'] : die();

$dqlSeriesNameSearchPattern = $search;
$query = $repository->createQueryBuilder('s')
	->where('s.SeriesName LIKE :name') // les contraintes
	->setParameter('name', '%'. $dqlSeriesNameSearchPattern .'%') // remplacer :name par l'expression '%88%'
    ->setMaxResults( 5 )
	->getQuery();
$dqlSeries = $query->getResult();


$result = [];
foreach ($dqlSeries as $serie) {
    $liste = array("serieName" => $serie->getName(), "episodes" => array() );
    foreach ($serie->episodes as $episode) {
        $liste['episodes'][] = $episode->getName();
    }
    $result[] = $liste;
}
$json = json_encode($result, JSON_PRETTY_PRINT);
echo $json;


/*echo "<pre>";*/
