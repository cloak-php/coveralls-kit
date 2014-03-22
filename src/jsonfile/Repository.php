<?php

/**
 * This file is part of CoverallsKit.
 *
 * (c) Noritaka Horio <holy.shared.design@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace coveralls\jsonfile;

use coveralls\ArrayConvertible;
use coveralls\jsonfile\repository\Commit;
use coveralls\jsonfile\repository\Remote;
use coveralls\jsonfile\repository\RemoteCollection;
use Gitonomy\Git\Repository as GitRepository;

class Repository implements ArrayConvertible
{

    protected $head = null;
    protected $branch = null;
    protected $remotes = null;

    public function __construct($directory)
    {
        $this->repository = new GitRepository($directory);
        $this->resolveHeadCommit()
            ->resolveBranch()
            ->resolveRemotes();
    }

    protected function resolveHeadCommit()
    {
        $headCommit = $this->repository->getHeadCommit();
        $this->head = new Commit($headCommit);
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
        $this->branch = $branch;

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

        $remotes = array_values($remoteMap);
        $remotes = new RemoteCollection();

        foreach ($remoteValues as $remote) {
            $remotes->add( new Remote($remote['name'], $remote['url']) );
        }
        $this->remotes = $remotes;

        return $this;
    }

    public function toArray()
    {
        $values = [
            'head' => $this->head->toArray(),
            'branch' => $this->branch,
            'remotes' => $this->remotes->toArray()
        ];

        return $values;
    }

    public function __toString()
    {
        return json_encode($this->toArray()); 
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->$name;
    }

}
