<?php


namespace console\controllers;

use common\models\object\Confidence;
use common\models\object\Object;
use common\models\object\ObjectConfidence;
use yii\console\Controller;

class ObjectController extends Controller
{
    public function actionAddObjectConfidences()
    {
        $allObjects = Object::find()->all();
        $confidenceIds = Confidence::find()->select('id')->column();
        if (!empty($allObjects)) {
            foreach ($allObjects as $object) {
                echo '<<< Start edit Object with id ' . $object->id . ' >>>';
                echo PHP_EOL;
                echo 'Getting ObjectConfidence\'s:';
                echo PHP_EOL;
                $objectConfidences = $object->getObjectConfidence()->indexBy('confidence_id')->all();
                $objectConfidencesIds = $object->getObjectConfidence()->select('confidence_id')->column();
                echo count($objectConfidences);
                echo PHP_EOL;
                echo 'Getting checked confidence\'s:';
                echo PHP_EOL;
                $checkedConfidences = $object->getConfidence()->select('id')->column();
                echo count($checkedConfidences);
                echo PHP_EOL;
                if (!empty($objectConfidences)) {
                    echo 'Delete not existing Object confidence\'s:';
                    echo PHP_EOL;
                    $idsDiff = array_diff($objectConfidencesIds, $confidenceIds);
                    if (!empty($idsDiff)) {
                        foreach ($idsDiff as $diffId) {
                            echo 'Deleting ObjectConfidence with id:';
                            echo PHP_EOL;
                            echo $diffId;
                            echo PHP_EOL;
                            $objectConfidences[$diffId]->delete();
                        }
                    }
                }
                if (!empty($confidenceIds)) {
                    foreach ($confidenceIds as $confidenceId) {
                        if (!in_array($confidenceId, $objectConfidencesIds)) {
                            echo "Add ObjectConfidence's with confidence_id({$confidenceId}) and object_id({$object->id})...";
                            echo PHP_EOL;
                            $objectConfidence = new ObjectConfidence();
                            $objectConfidence->confidence_id = $confidenceId;
                            $objectConfidence->object_id = $object->id;
                            if (in_array($confidenceId, $checkedConfidences)) {
                                $objectConfidence->check = true;
                            }
                            $objectConfidence->save();
                            echo "Done.";
                            echo PHP_EOL;
                        }
                    }
                }

                /**
                 * @var Object $object
                 */
//                var_dump($checkedConfidences);
//                echo PHP_EOL;
//                echo count($confidenceIds) . ' = = > ' . count($objectConfidences). ' = = > ' . count($checkedConfidences);
//                echo PHP_EOL;
            }
        }
    }
}
