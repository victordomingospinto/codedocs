<?php
namespace CodeDocs\Func;

use CodeDocs\Doc\MarkupFunction;
use CodeDocs\Exception\MarkupException;

/**
 * @CodeDocs\Topic(file="functions/constants.md")
 *
 * Returns a list of class constants.
 *
 * #### Parameters
 *
 * | Name    | Type   | Description
 * | ------- | -------| ------------
 * | of      | string | The class name
 * | matches | string | (Optional) Regex to filter constants
 *
 * #### Example
 *
 * ```
 * \{{ constants(of:'SomeClass') }}
 * \{{ constants(of:'SomeClass', matches:'/^TYPE_/') }}
 * ```
 */
class Constants extends MarkupFunction
{
    const FUNC_NAME = 'constants';

    /**
     * @param string $of
     * @param string $matches
     *
     * @return string[]
     * @throws MarkupException
     */
    public function __invoke($of, $matches = null)
    {
        $refClass = $this->state->getClass($of);

        if ($refClass === null) {
            throw new MarkupException(sprintf('class %s does not exist', $of));
        }

        $consts = [];

        foreach ($refClass->constants as $constant) {
            if (preg_match($matches, $constant->name)) {
                $consts[] = $constant->name;
            }
        }

        return $consts;
    }
}