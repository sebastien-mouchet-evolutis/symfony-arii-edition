<?php

/**
 * @SWG\Info(
 *   version="2.0.0",
 *   title="API pour les échanges avec le portail Ari'i",
 * )
 * 
 * @SWG\Response(
 *     response="default",
 *     description="an ""unexpected"" error"
 *   )
 * 
 * @SWG\Response(
 *   response="todo",
 *   description="This API call has no documentated response (yet)",
 * )
 * 
 * @SWG\Definition(
 *   definition="job_status",
 *   type="string",
 *   description="The status of a job",
 *   enum={"ACTIVE", "SUCCESS", "FAILURE"},
 *   default="ACTIVE"
 * )
 * 
 */
