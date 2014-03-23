<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\entity;

use coveralls\entity\repository\Commit;
use coveralls\entity\repository\Branch;
use coveralls\entity\repository\Remote;
use coveralls\entity\collection\RemoteCollection;
use Gitonomy\Git\Repository as GitRepository;

class Repository implements RepositoryInterface
{

    protected $repository = null;
    protected $head = null;
    protected $branch = null;
    protected $remotes = null;

    public function __construct($directory)
    {
        $this->repository = new GitRepository(realpath($directory));
        $this->resolveHeadCommit()
            ->resolveBranch()
            ->resolveRemotes();
    }

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

    protected function resolveBranch()
    {
        $commit = $this->repository->getHeadCommit();
        $branches = $this->repository->getReferences()->resolveBranches($commit);

        $localBranch = null;

        foreach ($branches as $branch) {
            if ($branch->isRemote() === true) {
                continue;
            }
            $localBranch = $branch;
        }

        $this->branch = new Branch([
            'name' => $localBranch->getName(),
            'remote' => $localBranch->isRemote()
        ]);

        return $this;
    }

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
            $remotes->add( new Remote($remote['name'], $remote['url']) );
        }
        $this->remotes = $remotes;

        return $this;
    }

    /**
     * @return coveralls\entity\repository\Commit
     */
    public function getCommit()
    {
        return $this->head; 
    }

    /**
     * @return coveralls\entity\repository\Branch
     */
    public function getBranch()
    {
        return $this->branch; 
    }

    /**
     * @return coveralls\entity\collection\RemoteCollection;
     */
    public function getRemotes()
    {
        return $this->remotes; 
    }

    public function toArray()
    {
        $values = [
            'head' => $this->getCommit()->toArray(),
            'branch' => (string) $this->getBranch(),
            'remotes' => $this->getRemotes()->toArray()
        ];

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray()); 
    }

}
