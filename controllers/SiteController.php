<?php

declare(strict_types=1);

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\exceptions\FileSystemException;
use app\Mappers\UserMapper;
use app\models\User;
use Exception;

class SiteController extends Controller
{
    public function presentation()
    {
        return $this->render('presentation');
    }

    public function handlePresentation(Request $request)
    {
        $body = $request->getBody();
        $mapper = new UserMapper();
        $rows = $mapper->findAll()->getNextRow();
        $this->render('presentation', ['rows' => $rows]);
    }
}