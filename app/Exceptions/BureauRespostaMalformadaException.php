<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Exceção lançada quando a resposta do Bureau é malformada.
 *
 * Cenário: resposta JSON sem a chave 'score'.
 */
class BureauRespostaMalformadaException extends RuntimeException
{
    //
}
