MVC2
---

### Model example

```php
<?php

namespace My\App;

use GSRO\DotKernel\MVC2\Model\CrudModelTrait;
use GSRO\DotKernel\MVC2\Model\BaseModel;

class MyModel extends BaseModel
{
	// for basic CRUD
	use CrudModelTrait;
	
	public function __construct($table = null)
    {
        parent::__construct();
        $this->table = $table ?? 'defaultTableName';
    }
}
```

### View

```php
<?php

namespace My\App;

use GSRO\DotKernel\MVC2\AdminViewTrait;
use GSRO\DotKernel\MVC2\FrontendViewTrait;
use GSRO\DotKernel\MVC2\View\ViewTrait;


class ProductView extends \View
{
    use ViewTrait;
	// for frontend:
	// use FrontendViewTrait;
	// for admin:
    use AdminViewTrait;
	
	public function viewAction($template, $data)
	{
		// ... your template code here ...
	}
	
	public function listAction($template, $data)
	{
		// ... your template code here ...
	}
	
	public function addAction($template, $data)
	{
		// ... your template code here ...
	}
}	
```


### Controller example

```php
<?php

namespace My\App;

use GSRO\DotKernel\MVC2\Controller\ControllerInterface;
use GSRO\DotKernel\MVC2\Controller\ControllerTrait;

class MyController implements ControllerInterface
{
	use ControllerTrait;
    
    public function __construct($registry = null, $tpl = null)
    {
        // Registry & Model & View
        $this->registry = $registry ?? Zend_Registry::getInstance();
        $this->model = new MyModel();
        $this->view = new MyView($tpl);
        
        $this->allowedActions = [
			// viewAction(), listAction(), addAction() will be called
            'view', 'list', 'add'
        ];
        $this->tpl = $tpl;
    }
    
    public function customBootstrap()
    {
        // TODO: Implement customBootstrap() method.
    }
	
	public function viewAction()
	{
	    $this->pageTitle = 'View Action';
		// ... your code here ...
	}
	
	public function listAction()
	{
		// ... your code here ...
	}
	
	public function addAction()
	{
		// ... your code here ...
	}
}

```

