<?php

namespace Blage\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Description of TaskType
 *
 * @author srohweder
 */
class TaskType extends AbstractType
{
    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Blage\TaskBundle\Entity\Task',
        );
    }
    
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('isDone', 'checkbox');
    }

    public function getName()
    {
        return 'task';
    }
}
