<?php

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="API voyage. Documentation", 
 *      description="Cette API permet aux tours-opérateurs de gérer les avis de leurs clients sur les voyages qu'ils proposent",
 *      version="1.0.0",
 *      termsOfService="http://www.monsite.com/terms",
 *      @OA\Contact(
 *          email="api.voyages@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * ),
 * @OA\Server(
 *      url="https://certificationphp.site/api"
 * ),
 * @OA\Tag(
 *      name="Clients",
 *      description="Ajouter, modifier, supprimer, lire un client"
 * ),
 *  @OA\Tag(
 *      name="Voyages",
 *      description="Ajouter, modifier, supprimer, lire un voyage"
 * ),
 *  @OA\Tag(
 *      name="Avis",
 *      description="Ajouter, modifier, supprimer, lire un avis"
 * )
 */