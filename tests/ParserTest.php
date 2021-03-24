<?php declare(strict_types=1);

namespace ACFParserTest;

use ACFParser\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testParseAppmanifest()
    {
        $parser = new Parser();

        $result = $parser->parse(file_get_contents(__DIR__.'/appmanifest.acf'));
        
        $this->assertSame($result, [
            'AppState' => [
                'appid' => '896660',
                'Universe' => '1',
                'name' => 'Valheim Dedicated Server',
                'StateFlags' => '4',
                'installdir' => 'Valheim dedicated server',
                'LastUpdated' => '1616606633',
                'UpdateResult' => '0',
                'SizeOnDisk' => '1053298784',
                'buildid' => '6394774',
                'LastOwner' => '76561200256042086',
                'BytesToDownload' => '0',
                'BytesDownloaded' => '0',
                'BytesToStage' => '0',
                'BytesStaged' => '0',
                'AutoUpdateBehavior' => '0',
                'AllowOtherDownloadsWhileRunning' => '0',
                'ScheduledAutoUpdate' => '0',
                'InstalledDepots' => [
                    '1006' => [
                        'manifest' => '383522337382622915',
                        'size' => '61451173',
                    ],
                    '896661' => [
                        'manifest' => '4011321630655889501',
                        'size' => '991847611',
                    ],
                ],
                'UserConfig' => [],
            ],
        ]);
    }

    public function testParseAppinfo()
    {
        $parser = new Parser();

        $result = $parser->parse(file_get_contents(__DIR__.'/appinfo.acf'));
        
        $this->assertSame($result, [
            '896660' => [
                'common' => [
                    'name' => 'Valheim Dedicated Server',
                    'type' => 'Tool',
                    'parent' => '892970',
                    'oslist' => 'windows,linux',
                    'osarch' => '',
                    'icon' => '1aab0586723c8578c7990ced7d443568649d0df2',
                    'logo' => '233d73a1c963515ee4a9b59507bc093d85a4e2dc',
                    'logo_small' => '233d73a1c963515ee4a9b59507bc093d85a4e2dc_thumb',
                    'clienticon' => 'c55a6b50b170ac6ed56cf90521273c30dccb5f12',
                    'clienttga' => '35e067b9efc8d03a9f1cdfb087fac4b970a48daf',
                    'ReleaseState' => 'released',
                    'associations' => [
                    ],
                    'gameid' => '896660',
                ],
                'config' => [
                    'installdir' => 'Valheim dedicated server',
                    'launch' => [
                        '0' => [
                            'executable' => 'start_server_xterm.sh',
                            'type' => 'server',
                            'config' => [
                                'oslist' => 'linux',
                            ]
                        ],
                        '1' => [
                            'executable' => 'start_headless_server.bat',
                            'type' => 'server',
                            'config' => [
                                'oslist' => 'windows',
                            ]
                        ],
                    ]
                ],
                'depots' => [
                    '1004' => [
                        'name' => 'Steamworks SDK Redist (WIN32)',
                        'config' => [
                            'oslist' => 'windows',
                        ],
                        'manifests' => [
                            'public' => '8183072803014619222',
                        ],
                        'maxsize' => '40080472',
                        'depotfromapp' => '1007',
                    ],
                    '1005' => [
                        'name' => 'Steamworks SDK Redist (OSX32)',
                        'config' => [
                            'oslist' => 'macos',
                        ],
                        'manifests' => [
                            'public' => '2135359612286175146',
                        ],
                        'depotfromapp' => '1007',
                    ],
                    '1006' => [
                        'name' => 'Steamworks SDK Redist (LINUX32)',
                        'config' => [
                            'oslist' => 'linux',
                        ],
                        'manifests' => [
                            'public' => '383522337382622915',
                        ],
                        'maxsize' => '61451173',
                        'depotfromapp' => '1007',
                    ],
                    '896661' => [
                        'name' => 'Valheim dedicated server Linux',
                        'config' => [
                            'oslist' => 'linux',
                        ],
                        'manifests' => [
                            'public' => '4011321630655889501',
                        ],
                        'maxsize' => '991847611',
                        'encryptedmanifests' => [
                            'experimental' => [
                                'encrypted_gid_2' => '39D636E394D16D95DCB77D85BF0B6DE2',
                                'encrypted_size_2' => '40DFB7176B3BA5331D35CBF5A8288092',
                            ],
                        ],
                    ],
                    '896662' => [
                        'name' => 'Valheim dedicated server Windows',
                        'config' => [
                            'oslist' => 'windows',
                        ],
                        'manifests' => [
                            'public' => '19916269069051077',
                        ],
                        'maxsize' => '984227085',
                        'encryptedmanifests' => [
                            'experimental' => [
                                'encrypted_gid_2' => '512DB3D3B147A41FDBE5626278EA1A86',
                                'encrypted_size_2' => '0AE29C3D6DBCE044E7509D62FD51B7BF',
                            ],
                        ],
                    ],
                    'branches' => [
                        'public' => [
                            'buildid' => '6394774',
                            'timeupdated' => '1616491334',
                        ],
                        'experimental' => [
                            'buildid' => '6336582',
                            'description' => 'Experimental version of Valheim',
                            'pwdrequired' => '1',
                            'timeupdated' => '1614953741',
                        ],
                        'unstable' => [
                            'buildid' => '6394774',
                            'description' => 'Unstable test version of valheim',
                            'pwdrequired' => '1',
                            'timeupdated' => '1615985248',
                        ],
                    ],
                ],
            ]
        ]);
    }
}

