<?php

/******************************************************************************
 *
 * Form
 *
 ******************************************************************************/

class Form
{
  protected $id;
  protected $attr = array();
  protected $fields = array();
  protected $values = array();
  protected $groups = array();

  protected $title = '';

  function __construct($id)
  {
    $this->id = $id;
  }

  function __toString()
  {
    $output = '';

    // Title
    if ($this->title)
    {
      $output .= htmlWrap('h1', $this->title);
    }

    // Fields.
    $fields_output = $this->buildGroup();

    // Form.
    $attr = $this->attr;
    $attr['id'] = $this->id;
    $attr['method'] = 'post';
    $output .= htmlWrap('form', $fields_output, $attr);
    return $output;
  }

  function setAttr($name, $value)
  {
    $this->attr[$name] = $value;
  }

  function setValues($values)
  {
    $this->values = $values;
  }

  function setTitle($title)
  {
    $this->title = $title;
  }

  function addGroup($group, $parent_group = 'default')
  {
    $this->groups[$group] = $parent_group;
    return $this;
  }

  function addField(Field $field)
  {
    if (is_array($this->values) && array_key_exists($field->getId(), $this->values))
    {
      $field->setValue($this->values[$field->getId()]);
    }
    $this->fields[] = $field;
  }

  function getAttr($name)
  {
    return isset($this->attr[$name]) ? $this->attr[$name] : FALSE;
  }

  function getTitle()
  {
    return $this->title;
  }

  function buildGroup($group_name = 'default')
  {
    $fields = array();
    foreach($this->fields as $field)
    {
      if ($field->getGroup() === $group_name)
      {
        $fields[] = $field->__toString();
      }
    }

    foreach($this->groups as $group => $group_parent)
    {
      if ($group_parent == $group_name)
      {
        $attr = array(
          'class' => array('field_group', $group),
        );
        $fields[] = htmlWrap('div', $this->buildGroup($group), $attr);
      }
    }

    return implode('', $fields);
  }
}

/******************************************************************************
 *
 * Fields.
 *
 ******************************************************************************/

abstract class Field
{
  protected $id;
  protected $attr = array();
  protected $label = '';
  protected $value = '';
  protected $group = '';

  function __construct($id, $label = '')
  {
    $this->id = $id;
    $this->label = $label;
  }
  abstract function __toString();

  function setLabel($label)
  {
    $this->label = $label;
    return $this;
  }

  function setValue($value)
  {
    $this->value = $value;
    return $this;
  }
  function setGroup($group)
  {
    $this->group = $group;
    return $this;
  }

  function getId()
  {
    return $this->id;
  }

  function getValue()
  {
    return $this->value;
  }

  function setAttr($name, $value)
  {
    assert(($name === 'class' && is_array($value)) || $name !== 'class');
    $this->attr[$name] = $value;
    return $this;
  }
  function getGroup()
  {
    if (!$this->group)
    {
      return 'default';
    }
    return $this->group;
  }

  function setRequired($required = TRUE)
  {
    if ($required)
    {
      $this->attr['required'] = $required;
    }
    elseif ($this->attr['required'])
    {
      unset($this->attr['required']);
    }
  }
}

class FieldHidden extends Field
{
  function __construct($id, $value = '', $label = '')
  {
    parent::__construct($id, $label);
    $this->value = $value;
  }

  function __toString()
  {
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = 'hidden';
    if ($this->value)
    {
      $attr['value'] = $this->value;
    }

    $output = htmlSolo('input', $attr);
    return $output;
  }
}

class FieldText extends Field
{
  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Input.
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = CreateQuery::TYPE_STRING;
//    if ($this->value)
//    {
      $attr['value'] = $this->value;
//    }
    $output .= htmlSolo('input', $attr);

    // Wrapper.
    $attr = array('class' => array('field', CreateQuery::TYPE_STRING, $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldPassword extends Field
{
  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Input.
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = 'password';
    if ($this->value)
    {
      $attr['value'] = $this->value;
    }
    $output .= htmlSolo('input', $attr);

    // Wrapper.
    $attr = array('class' => array('field', CreateQuery::TYPE_STRING, $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldNumber extends Field
{
  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Input.
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = 'number';
    if ($this->value !== FALSE)
    {
      $attr['value'] = $this->value;
    }
    $output .= htmlSolo('input', $attr);

    // Wrapper.
    $attr = array('class' => array('field', CreateQuery::TYPE_STRING, $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldSelect extends Field
{
  protected $options;

  function __construct($id, $name = '', $options = array())
  {
    parent::__construct($id, $name);
    $this->setOptions($options);
  }

  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Options.
    $select_options = '';
    foreach($this->options as $id => $label)
    {
      $attr = array('value' => $id);
      if ($id == $this->value)
      {
        $attr['selected'] = 'selected';
      }
      $select_options .= htmlWrap('option', $label, $attr);
    }

    // Select.
    $attr = $this->attr;
    $attr['name'] = $this->id;
    $output .= htmlWrap('select', $select_options, $attr);

    // Wrapper.
    $attr = array('class' => array('field', 'select', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }

  function setOptions($options)
  {
    $this->options = $options;
    return $this;
  }
}

class FieldRadio extends FieldSelect
{
  protected $options;

  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('radio-header'));
    $output .= htmlWrap('h5', $this->label, $attr);

    // Options.
    $select_options = '';
    foreach($this->options as $id => $label)
    {
      $input_attr = array(
        'type' => 'radio',
        'id' => $id,
        'name' => $this->id,
        'value' => $id,
      );
      $input_attr['type'] = 'radio';
      if ($id == $this->value)
      {
        $input_attr['selected'] = 'selected';
      }
      $select_options .= htmlSolo('input', $input_attr);
      $label_attr = array('for' => $id);
      $select_options .= htmlWrap('label', $label, $label_attr);
    }

    // Select.
    $wrapper_attr = array('class' => array('radio-wrapper'));
    $output .= htmlWrap('div', $select_options, $wrapper_attr);

    // Wrapper.
    $attr = array('class' => array('field', 'radio', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldAutocomplete extends Field
{
  protected $url;

  function __construct($id, $name, $url)
  {
    parent::__construct($id, $name);
    $this->setUrl($url);
  }

  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Visible Field.
    $attr = $this->attr;
    $attr['name'] = $this->id . '-search';
    $attr['type'] = 'autocomplete';
    $attr['callback'] = $this->url;
    $output .= htmlWrap('input', '', $attr);

    // Invisible ID storage.
    $attr = $this->attr;
    $attr['name'] = $this->id;
    $attr['type'] = 'hidden';
//    $attr['class'] = array('hidden');
    $output .= htmlWrap('input', '', $attr);

    // Wrapper.
    $attr = array('class' => array('field', 'autocomplete', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }

  function setUrl($url)
  {
    $this->url = $url;
    return $this;
  }
}

class FieldCheckbox extends Field
{
  function __toString()
  {
    $output = '';

    // Input.
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = 'checkbox';
    if ($this->value)
    {
      $attr['checked'] = 'checked';
    }
    $output .= htmlSolo('input', $attr);

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Wrapper.
    $attr = array('class' => array('field', 'checkbox', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldTextarea extends Field
{
  protected $rows = 5;
  protected $cols = 100;

  function __toString()
  {
    $output = '';

    // Label.
    $attr = array('class' => array('label'), 'for' => $this->id);
    $output .= htmlWrap('label', $this->label, $attr);

    // Input.
    $attr = $this->attr;
//    $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['rows'] = $this->rows;
    $attr['cols'] = $this->cols;
    $output .= htmlWrap('textarea', $this->value, $attr);

    // Wrapper.
    $attr = array('class' => array('field', 'textarea', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }

  function setRows($rows)
  {
    $this->rows = $rows;
    return $this;
  }

  function setCols($cols)
  {
    $this->cols = $cols;
  }
}

class FieldSubmit extends Field
{
  function __construct($id, $value = '')
  {
    parent::__construct($id);
    $this->value = $value;
  }

  function __toString()
  {
    // Input.
    $attr = $this->attr;
//   $attr['id'] = $this->id;
    $attr['name'] = $this->id;
    $attr['type'] = 'submit';
    if ($this->value)
    {
      $attr['value'] = $this->value;
    }

    $output = htmlSolo('input', $attr);

    // Wrapper.
    $attr = array('class' => array('field', $this->id));
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}

class FieldMarkup extends Field
{
  function __construct($id, $label = '', $value = '')
  {
    parent::__construct($id, $label);
    $this->value = $value;
  }

  function __toString()
  {
    $output = '';

    // Label.
    if ($this->label)
    {
      $attr = array('class' => array('label'), 'for' => $this->id);
      $output .= htmlWrap('label', $this->label, $attr);
    }

    // Output.
    $output .= htmlWrap('div', $this->value, array('class' => 'markup-value'));

    // Wrapper.
    $attr = $this->attr;
    $attr['class'] = iis($attr, 'class', array());
    $attr['class'][] = 'field';
    $attr['class'][] = 'markup';
    $attr['class'][] = $this->id;
    $output = htmlWrap('div', $output, $attr);
    return $output;
  }
}
