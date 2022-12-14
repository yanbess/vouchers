<?php


namespace App\Http\Controllers;


trait ResponseTrait
{
    /**
     * @var array
     */
    public $response;

    /**
     * @param integer $code
     */
    public function setStatusCode($code)
    {
        $this->response['code'] = $code;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getResponse(): \Illuminate\Http\JsonResponse
    {
        if (!isset($this->response['success'])) {
            $this->response['success'] = true;
        }
        return response()->json($this->response, $this->response['code'] ?? 200);
    }

    /**
     * @param array $errors
     */
    public function setValidationErrors($errors = [])
    {
        foreach ($errors as $field => $errorsArr) {

            foreach ($errorsArr as $index => $error) {
                $errorsArr[$index] = __($error);
            }

            $this->response['validation_errors'][$field] = implode("/n", $errorsArr);
        }

        $this->response['success'] = false;
        $this->setStatusCode(422);
    }

    /**
     * @param array $data
     * @param integer $code
     * @param boolean $success
     */
    public function setResponseData($data = [], $code = 200, $success = true)
    {
        $this->response['data'] = $data;
        $this->response['success'] = $success;
        $this->setStatusCode($code);
    }

    /**
     * @param string $error
     * @param integer $code
     * @param boolean $success
     */
    public function setErrorMessage($error, $code = 422, $success = false)
    {
        $this->response['message'] = __($error);
        $this->response['success'] = $success;
        $this->setStatusCode($code);
    }
}
