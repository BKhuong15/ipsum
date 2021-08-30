<?php

/******************************************************************************
 *
 * Page Templates.
 *
 ******************************************************************************/

/**
 * Class HTMLTemplate
 */
class HTMLTemplate
{
  protected $title = '';
  protected $css_file_paths = array();
  protected $js_file_paths = array();
  protected $messages = array();
  protected $body_attr = array();
  protected $body = '';

  function __construct()
  {
    // Global.
    $this->addCssFilePath('/themes/default/css/page.css');
    $this->addCssFilePath('/themes/default/css/form.css');

    // Jquery.
    $this->addJsFilePath('/libraries/jquery/jquery.min.js');
    $this->addJsFilePath('/libraries/jquery/jquery-ui.min.js');
    $this->addCssFilePath('/libraries/jquery/jquery-ui.min.css');

    $this->addJsFilePath('/libraries/global.js');
  }

  function __toString()
  {
    if (isset($_SESSION) && isset($_SESSION['messages']))
    {
      $this->messages = $_SESSION['messages'];
      $_SESSION['messages'] = array();
    }

    // Head.
    $output = '';
    $output .= htmlWrap('title', $this->title);
    foreach($this->css_file_paths as $css_file_path)
    {
      $attr = array(
        'rel' => 'stylesheet',
      );
      if (CLEAN_URLS)
      {
        $attr['href'] = $css_file_path;
      }
      else
      {
        $attr['href'] = 'http://127.0.0.1/5eTemplates' . $css_file_path;
      }
      $output .= htmlSolo('link', $attr);
    }
    $output .= htmlWrap('script', 'var CLEAN_URLS=' . CLEAN_URLS . ';');
    foreach($this->js_file_paths as $js_file_path)
    {
      $attr = array();
      if (CLEAN_URLS)
      {
        $attr['src'] = $js_file_path;
      }
      else
      {
        $attr['src'] = 'http://127.0.0.1/5eTemplates' . $js_file_path;
      }
      $output .= htmlWrap('script', '', $attr);
    }
    $output = htmlWrap('head', $output);

    // Body.
    $output .= htmlWrap('body', $this->body, $this->body_attr);
    $output = '<!DOCTYPE HTML>' . htmlWrap('html', $output);
    return $output;
  }

  function setTitle($title)
  {
    $this->title = $title;
  }
  function addCssFilePath($path)
  {
    $this->css_file_paths[] = $path;
  }
  function addJsFilePath($path)
  {
    $this->js_file_paths[] = $path;
  }
  function setBodyAttr($attr)
  {
    $this->body_attr = $attr;
  }
  function getBodyAttr()
  {
    return $this->body_attr;
  }
  function setBody($body)
  {
    $this->body = $body;
  }
}

/**
 * Class ListTemplate
 */
class ListPageTemplate extends HTMLTemplate
{
  protected $name = '';
  protected $list_path = '';
  protected $list_item_path = '';
  protected $page = 1;
  protected $create = FALSE;
  protected $list = '';

  function __construct($name, $list_path, $list_item_path)
  {
    parent::__construct();

    $this->setTitle($name);
    $this->list = new TableTemplate();
    $this->name = $name;
    $this->list_path = $list_path;
    $this->list_item_path = $list_item_path;
    $this->setBodyAttr(array('id' => stringToAttr($name)));
    $this->menu = menu();
  }

  function __toString()
  {
    $output = menu();
    $output .= htmlWrap('h1', $this->name);

    // Operations.
    $operations = '';
    if ($this->create)
    {
      $operations .= a($this->create, $this->list_item_path, array('class' => array('create')));
    }
    if ($this->page)
    {
      if ($this->page > 1)
      {
        $attr = array(
          'query' => array('page' => ($this->page - 1)),
        );
        $operations .= a('Prev Page', $this->list_path, $attr);
      }

      if ($this->list->count() >= PAGER_SIZE_DEFAULT)
      {
        $attr = array(
          'query' => array('page' => ($this->page + 1)),
        );
        $operations .= a('Next Page', $this->list_path, $attr);
      }
    }
    $output .= htmlWrap('div', $operations, array('class' => array('operations')));

    // Table.
    $output .= $this->list;
    $this->setBody($output);
    return parent::__toString();
  }

  function setPage($page = 1)
  {
    $this->page = $page;
  }

  function setCreate($create_label)
  {
    $this->create = $create_label;
  }

  function setList(TableTemplate $list)
  {
    $this->list = $list;
  }
}

/**
 * Class ListTemplate
 */
class FormPageTemplate extends HTMLTemplate
{
  protected $messages = '';
  protected $form = '';
  protected $upper = '';

  function __construct()
  {
    parent::__construct();
  }

  function __toString()
  {
    // Body.
    $body = '';
    $body .= menu();
    $body .= $this->messages;
    $body .= $this->upper;
    $body .= $this->form;
    $this->setBody($body);

    // Wrapper.
    return parent::__toString();
  }

  function setMessages($messages)
  {
    $this->messages = $messages;
  }

  function addMessage($message)
  {
    $this->messages .= $message;
  }

  function setForm(Form $form)
  {
    $this->setTitle($form->getTitle());

    $this->form = $form;
  }

  /**
   * @param string $upper
   */
  public function setUpper($upper)
  {
    $this->upper = $upper;
  }
}

/******************************************************************************
 *
 * HTML Structures
 *
 ******************************************************************************/

/**
 * Class TableTemplate
 */
Class TableTemplate
{
  // Primary values.
  protected $header = array();
  protected $rows = array();

  protected $attr = array();
  protected $row_attr = array();

  /**
   * Standard constructor. Pass the path to the template file.
   */
  public function __construct($id = FALSE)
  {
    if ($id)
    {
      $attr['id'] = $id;
    }
  }

  public function setHeader($header)
  {
    $this->header = $header;
    return $this;
  }
  public function addRows($rows)
  {
    $this->rows = $rows;
    $this->attr = array_fill(0, count($rows), array());
    return $this;
  }
  public function addRow($row, $row_attr = array())
  {
    $this->rows[] = $row;
    $this->row_attr[] = $row_attr;
    return $this;
  }
  public function setAttr($name, $value)
  {
    $this->attr[$name] = $value;
  }
  public function count()
  {
    return count($this->rows);
  }
  public function __toString()
  {
    $output = '';

    // Generate table.
    $output .= $this->generateHTMLHeader();
    $output .= $this->generateHTMLRows();

    $output = htmlWrap('table', $output, $this->attr);
    return $output;
  }

  private function generateHTMLHeader()
  {
    // Header columns.
    $output = '';
    $count = 1;
    foreach ($this->header as $label)
    {
      $attr = array('class' => array('column-' . $count));
      $output .= htmlWrap('th', $label, $attr);
      $count++;
    }

    // Header wrappers.
    $output = htmlWrap('tr', $output);
    $output = htmlWrap('thead', $output);
    return $output;
  }

  private function generateHTMLRows()
  {
    $output = '';
    $row_attr = reset($this->row_attr);
    foreach ($this->rows as $row)
    {
      $row_output = '';
      $count = 0;
      foreach ($row as $cell)
      {
        $cell_attr = iis($row_attr, $count, array());
        $cell_attr['class'] = iis($cell_attr, 'class', array());
        $cell_attr['class'][] = 'column-' . ($count + 1);
        $row_output .= htmlWrap('td', $cell, $cell_attr);
        $count++;
      }
      $output .= htmlWrap('tr', $row_output, $row_attr);
      $row_attr = next($this->row_attr);
    }
    $output = htmlWrap('tbody', $output);
    return $output;
  }

  static function tableRow($row, $attr = array())
  {
    $output = '';
    $count = 1;
    foreach ($row as $cell)
    {
      $attr = iis($attr, 0, array());
      $class = iis($attr, 'class', array());
      assert(is_array($class));
      $class[] = 'column-' . $count;
      $attr['class'] = $class;
      $output .= htmlWrap('td', $cell, $attr);
      $count++;
    }
    return htmlWrap('tr', $output, $attr);
  }
}

Class ListTemplate
{
  protected $list;
  protected $list_type;
  protected $attr;
  protected $pointer = 0;

  public function __construct($list_type = 'ol')
  {
    $this->list_type = $list_type;
  }

  public function setListType($list_type)
  {
    $this->list_type = $list_type;
  }

  public function addListItem($item, $attr = array())
  {
    $this->list[$this->pointer] = $item;
    $this->attr[$this->pointer] = $attr;
    $this->pointer++;
  }

  public function setAttr($attr)
  {
    $this->attr = array_merge($this->attr, $attr);
  }

  public function __toString()
  {
    $output = '';

    for($k = 0; $k < $this->pointer; $k++)
    {
      $list_item = $this->list[$k];
      $attr = $this->attr[$k];
      $output .= htmlWrap('li', $list_item, $attr);
    }

    $output = htmlWrap($this->list_type, $output, $attr);
    return $output;
  }

}