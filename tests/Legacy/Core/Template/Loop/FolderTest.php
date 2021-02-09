<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace Thelia\Tests\Core\Template\Loop;

use Thelia\Core\Template\Loop\Folder;
use Thelia\Model\FolderQuery;
use Thelia\Tests\Core\Template\Element\BaseLoopTestor;

/**
 *
 * @author Etienne Roudeix <eroudeix@openstudio.fr>
 *
 */
class FolderTest extends BaseLoopTestor
{
    public function getTestedClassName()
    {
        return 'Thelia\Core\Template\Loop\Folder';
    }

    public function getMandatoryArguments()
    {
        return [];
    }

    public function testSearchById()
    {
        $folder = FolderQuery::create()->findOne();
        if (null === $folder) {
            $folder = new \Thelia\Model\Folder();
            $folder->setParent(0);
            $folder->setVisible(1);
            $folder->setTitle('foo');
            $folder->save();
        }

        $otherParameters = [
            "visible" => "*",
        ];

        $this->baseTestSearchById($folder->getId(), $otherParameters);
    }

    public function testSearchLimit()
    {
        $this->baseTestSearchWithLimit(3);
    }
}
