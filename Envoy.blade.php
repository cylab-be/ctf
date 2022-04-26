# !! @servers must be on a single line !!
@servers(['servers' => ['ctf@ctf.cylab.be']])

@setup
    $root = '/home/ctf';
    $tmp = '/tmp/ctf';
@endsetup


@task('deploy', ['on' => 'servers'])
    echo 'fetch new docker-compose.yml ...'
    rm -Rf {{ $tmp }}
    mkdir {{ $tmp }}
    cd {{ $tmp }}
    wget https://download.cylab.be/ctf/latest/docker-compose.yml
    mv -f docker-compose.yml {{ $root }}

    echo 'restart updated containers ...'
    cd {{ $root }}
    docker-compose up -d
@endtask

