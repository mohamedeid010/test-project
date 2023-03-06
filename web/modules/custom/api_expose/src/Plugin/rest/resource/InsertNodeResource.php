<?php

namespace Drupal\api_expose\Plugin\rest\resource;

use Drupal\api_base_handler\Response\APIResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\node\Entity\Node;

/**
 * Represents Insert node as a resource.
 *
 * @RestResource(
 *   id = "api_expose_inser_node_resource",
 *   label = @Translation("Insert node Resource"),
 *   uri_paths = {
 *     "create" = "/api/insert-node",
 *   }
 * )
 */
class InsertNodeResource extends ResourceBase {

    /**
     * Represents POST
     */
    public function post($data) {
        $tempstore = \Drupal::service('tempstore.shared')->get('api_validation');

        //Validate missing or empty data
        $required = ['title', 'email','idnumber','phone','summry'];
        foreach ($required as $argument) {
            if (!in_array($argument, array_keys($data)) ||
                    (in_array($argument, array_keys($data)) && empty($data[$argument]))) {
                $tempstore->set('validation_errors', ['FIELD_IS_REQUIRED', t($argument . ' is required')]);
                return new APIResponse([], 400);
            }
        }
           ///////////////////////////////////////////////
         $node = Node::create(['type' => 'second_content_type']);
         $node->set('title', $data['title']);
         $node->set('field_email', $data['email']);
         $node->set('field_id_number', $data['idnumber']);
         $node->set('field_phone', $data['phone']);
         $node->set('field_summary', $data['summry']);
         $node->save();  
         $msg = array("node saved Successfully");
         return new APIResponse($msg); 
    }

}
