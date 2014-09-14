<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coverallskit\entity;

use coverallskit\entity\repository\Commit;
use coverallskit\entity\repository\Branch;
use coverallskit\entity\repository\Remote;
use coverallskit\entity\collection\RemoteCollection;
use Gitonomy\Git\Repository as GitRepository;
use coverallskit\AttributePopulatable;

/**
 * Class Repository
 * @package coverallskit\entity
 */
class Repository implements RepositoryInterface
{

    use AttributePopulatable;

    /**
     * @var \Gitonomy\Git\Repository
     */
    protected $repository;

    /**
     * @var \coverallskit\entity\repository\Commit
     */
    protected $head;

    /**
     * @var \coverallskit\entity\repository\Branch
     */
    protected $branch;

    /**
     * @var \coverallskit\entity\collection\RemoteCollection
     */
    protected $remotes;


    /**
     * @param string $directory
     */
    public function __construct($directory)
    {
        $this->repository = new GitRepository(realpath($directory));
        $this->resolveHeadCommit()
            ->resolveBranch()
            ->resolveRemotes();
    }

    /**
     * @return $this
     */
    protected function resolveHeadCommit()
    {
        $headCommit = $this->repository->getHeadCommit();
        $this->head = new Commit([
            'id' => $headCommit->getHash(),
            'authorName' => $headCommit->getAuthorName(),
            'authorEmail' => $headCommit->getAuthorEmail(),
            'committerName' => $headCommit->getCommitterName(),
            'committerEmail' => $headCommit->getCommitterEmail(),
            'message' => $headCommit->getMessage()
        ]);

        return $this;
    }

    /**
     * @return $this
     */
    protected function resolveBranch()
    {
        $commit = $this->repository->getHeadCommit();
        $branches = $this->repository->getReferences()->resolveBranches($commit);

        $resolveBranch = $this->getDefaultBranch();

        foreach ($branches as $branch) {
            if ($branch->isRemote() === true) {
                continue;
            }
            $resolveBranch = new Branch([
                'name' => $branch->getName(),
                'remote' => $branch->isRemote()
            ]);
        }

        $this->branch = $resolveBranch;

        return $this;
    }

    /**
     * @return $this
     */
    protected function resolveRemotes()
    {
        $remotes = $this->repository->run('remote', array('-v'));
        $remotes = explode("\n", $remotes);

        $remoteMap = array();

        foreach ($remotes as $remote) {
            if (empty($remote) === true) {
                continue;
            }
            preg_match("/(.+)\s(.+\.git)/", $remote, $mathes);

            $name = $mathes[1];
            $url = $mathes[2];

            $remoteMap[$name] = array(
                'name' => $name,
                'url' => $url
            );
        }

        $remoteValues = array_values($remoteMap);
        $remotes = new RemoteCollection();

        foreach ($remoteValues as $remote) {
            $remotes->add( new Remote($remote) );
        }
        $this->remotes = $remotes;

        return $this;
    }

    /**
     * @return \coverallskit\entity\repository\Branch
     */
    protected function getDefaultBranch()
    {
        $branch = new Branch([
            'name' => 'master',
            'remote' => false
        ]);

        return $branch;
    }

    /**
     * @return \coverallskit\entity\repository\Commit
     */
    public function getCommit()
    {
        return $this->head;
    }

    /**
     * @return \coverallskit\entity\repository\Branch
     */
    public function getBranch()
    {
        return $this->branch;
    }

    /**
     * @return \coverallskit\entity\collection\RemoteCollection;
     */
    public function getRemotes()
    {
        return $this->remotes;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        $commit = $this->getCommit();
        return empty($commit);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $values = [
            'head' => $this->getCommit()->toArray(),
            'branch' => (string) $this->getBranch(),
            'remotes' => $this->getRemotes()->toArray()
        ];

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

}
