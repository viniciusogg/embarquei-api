<?php
/**
 * Created by PhpStorm.
 * User: vinicius
 * Date: 17/02/19
 * Time: 21:14
 */

namespace App\Repositories\Implementation;

use App\Repositories\Abstraction\FeedbackRepositoryInterface;
use App\Repositories\Abstraction\Repository;

class FeedbackRepositoryConcrete extends Repository implements FeedbackRepositoryInterface
{

    protected function getTypeObject()
    {
        return '\App\Entities\Feedback';
    }
}