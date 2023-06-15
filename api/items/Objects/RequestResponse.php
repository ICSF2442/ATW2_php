<?php

namespace Objects;

class RequestResponse
{

    private mixed $result = null;

    private ?bool $isError = false;

    private ?string $error = null;

    /**
     * @return mixed
     */
    public function getResult(): mixed
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult(mixed $result): RequestResponse
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsError(): ?bool
    {
        return $this->isError;
    }

    /**
     * @param bool|null $isError
     */
    public function setIsError(?bool $isError): RequestResponse
    {
        $this->isError = $isError;
        if(!$isError){
            $this->error = null;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getError(): ?string
    {
        return $this->error;
    }

    /**
     * @param string|null $error
     */
    public function setError(?string $error): RequestResponse
    {
        $this->error = $error;
        if(!$error){
            $this->error = null;
        }
        return $this;
    }


    public function response(bool $print = true): string|bool
    {
        $json = json_encode(array(
            "result" => $this->result,
            "isError" => $this->isError,
            "error" => $this->error
        ));
        if($print) echo $json;
        return $json;
    }



}