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
     * @return coverallskit\entity\repository\Commit
     */
    public function getCommit()
    {
        return $this->head; 
    }

    /**
     * @return coverallskit\entity\repository\Branch
     */
    public function getBranch()
    {
        return $this->branch; 
    }

    /**
     * @return coverallskit\entity\collection\RemoteCollection;
     */
    public function getRemotes()
    {
        return $this->remotes; 
    }

    public function isEmpty()
    {
        return empty($this->getCommit());
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
