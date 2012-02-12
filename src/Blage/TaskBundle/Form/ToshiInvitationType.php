<?php

namespace Blage\TaskBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;

class ToshiInvitationType extends AbstractType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('email', 'email');
    }

    public function getName()
    {
        return 'toshiinvitation';
    }

    public function getDefaultOptions(array $options)
    {
        $collectionConstraint = new Collection(array(
                    'email' => new Email(array('message' => 'Invalid email address')),
                ));

        return array('validation_constraint' => $collectionConstraint);
    }

}
