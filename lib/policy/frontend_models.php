<?


$policy = function($rq, $res) {
	$fc = $rq->fconfig;
	$fc['ui'] = array();
	$rq->fconfig = $fc;

	return true;
};
