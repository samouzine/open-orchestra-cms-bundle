<?php

namespace OpenOrchestra\Backoffice\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class TrashcanRemoveNode
 */
class TrashcanRemoveNode extends Constraint
{
    public $message = 'open_orchestra_backoffice_validators.trashitem.remove_node_date';

    /**
     * @return string
     */
    public function validatedBy()
    {
        return 'remove_node_date';
    }

    /**
     * @return string
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
