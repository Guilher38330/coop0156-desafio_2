<?php

namespace App\Exceptions;

use RuntimeException;

/**
 * Exceção lançada quando o Bureau de Crédito está indisponível.
 *
 * Cenários: HTTP 500, timeout, falha de conexão.
 */
class BureauIndisponivelException extends RuntimeException
{
    //
}
