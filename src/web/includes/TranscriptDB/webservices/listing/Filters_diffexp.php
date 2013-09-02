<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 *  returns possible filters to display differential expressions
 * Designed for use with filteredSelect javascript class
 */
class Filters_diffexp extends \WebService {

    /**
     * filters for diffexp for specified ids
     * @see \webservices\listing\Filters::execute
     */
    public function forCart($querydata) {
        global $db;
#UI hint
        if (false)
            $db = new PDO();



        $ids = array();
        if (isset($querydata['ids'])) {
            $ids = array_merge($ids, $querydata['ids']);
        }

        if (count($ids)==0)
            return array();

        $place_holders = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  DISTINCT
  --d.feature_id AS feature_id,
  analysis.analysis_id, analysis.name AS analysis_name, analysis.description AS analysis_description, analysis.program AS analysis_program, analysis.programversion AS analysis_programversion, analysis.algorithm AS analysis_algorithm,
  ba.biomaterial_id AS ba_id, ba.name AS ba_name, ba.description AS ba_description,
  bb.biomaterial_id AS bb_id, bb.name AS bb_name, bb.description AS bb_description,
  assay.name AS assay_name, assay.description AS assay_description, assay.assay_id
FROM 
  diffexpresult d
  JOIN analysis ON (d.analysis_id = analysis.analysis_id)
  JOIN biomaterial ba ON (d.biomateriala_id = ba.biomaterial_id)
  JOIN biomaterial bb ON (d.biomaterialb_id = bb.biomaterial_id)
  JOIN quantification ON (d.quantification_id=quantification.quantification_id)
  JOIN acquisition ON (quantification.acquisition_id = acquisition.acquisition_id)
  JOIN assay ON (acquisition.assay_id=assay.assay_id)
WHERE 
  d.feature_id IN ({$place_holders});
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array();

        $stm_get_filters->execute($ids);
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {

            $data['data']['analysis'][$filter['analysis_id']] = self::getItem('analysis', $filter);
            $data['data']['ba'][$filter['ba_id']] = self::getItem('ba', $filter);
            $data['data']['ba'][$filter['bb_id']] = self::getItem('bb', $filter);
            $data['data']['assay'][$filter['assay_id']] = self::getItem('assay', $filter);

            $data['values'][] = array(
                'analysis' => $filter['analysis_id'],
                'ba' => $filter['ba_id'],
                'bb' => $filter['bb_id'],
                'assay' => $filter['assay_id'],
                'dir' => 'ltr'
            );
            // add flip
            $data['values'][] = array(
                'analysis' => $filter['analysis_id'],
                'bb' => $filter['ba_id'],
                'ba' => $filter['bb_id'],
                'assay' => $filter['assay_id'],
                'dir' => 'rtl'
            );
        }
        $data['data']['bb'] = &$data['data']['ba'];
        return $data;
    }

    /**
     * filters for diffexp for full release
     * @see \webservices\listing\Filters::execute
     */
    public function fullRelease($querydata) {
        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';

//

        $query_get_filters = <<<EOF
SELECT 
    ba.name AS ba_name, ba_id, 
    bb.name AS bb_name, bb_id,
    analysis.name AS analysis_name, ids.analysis_id,
    assay.name AS assay_name, assay.description AS assay_description, assay.assay_id
FROM
    materialized_view_diffexp_filter AS ids
JOIN biomaterial ba ON (ids.ba_id=ba.biomaterial_id)
JOIN biomaterial bb ON (ids.bb_id=bb.biomaterial_id)
JOIN analysis ON (ids.analysis_id=analysis.analysis_id)
JOIN quantification ON (ids.quantification_id=quantification.quantification_id)
JOIN acquisition ON (quantification.acquisition_id = acquisition.acquisition_id)
JOIN assay ON (acquisition.assay_id=assay.assay_id)

WHERE 
    ids.organism_id=? AND ids.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')}  AND accession = ?)
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array();  

        $stm_get_filters->execute(array($organism, $release));
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {

            $data['data']['analysis'][$filter['analysis_id']] = self::getItem('analysis', $filter);
            $data['data']['ba'][$filter['ba_id']] = self::getItem('ba', $filter);
            $data['data']['ba'][$filter['bb_id']] = self::getItem('bb', $filter);
            $data['data']['assay'][$filter['assay_id']] = self::getItem('assay', $filter);

            $data['values'][] = array(
                'analysis' => $filter['analysis_id'],
                'ba' => $filter['ba_id'],
                'bb' => $filter['bb_id'],
                'assay' => $filter['assay_id'],
                'dir' => 'ltr'
            );
            // add flip
            $data['values'][] = array(
                'analysis' => $filter['analysis_id'],
                'bb' => $filter['ba_id'],
                'ba' => $filter['bb_id'],
                'assay' => $filter['assay_id'],
                'dir' => 'rtl'
            );
        }
        $data['data']['bb'] = &$data['data']['ba'];
        return $data;
    }

    /**
     * different behaviour for query1= "forCart" or "fullRelease"
     * @inheritDoc
     */
    public function execute($querydata) {
        if ($querydata['query1'] == "forCart") {
            return $this->forCart($querydata);
        } else if ($querydata['query1'] == "fullRelease") {
            return $this->fullRelease($querydata);
        }
    }

    /**
     * returns an Array of all $row values whose key begins with $item_prefix (removing prefix)
     * @param String $item_prefix
     * @param Array $row
     * @return Array item
     */
    private static function getItem($item_prefix, $row) {
        $item = array();
        foreach ($row as $key => $val) {
            $match = null;
            if (preg_match("/${item_prefix}_(.*)/", $key, $match)) {
                $item[$match[1]] = $val;
            }
        }
        return $item;
    }

}

?>
