<?php

    namespace khm\ThirdParty;

    use khm\Objects\OnionRelay;
    use WpOrg\Requests\Requests;

    class TorProject
    {
        /**
         * Returns an array of onion relays from the Tor network
         *
         * @return OnionRelay[]
         */
        public static function getRelays(): array
        {
            $data = json_decode(Requests::get('https://onionoo.torproject.org/details')->body, true);
            $results = [];

            foreach($data['relays'] as $relay)
            {
                $onion_relay = new OnionRelay();

                // match the main ip address
                foreach ($relay['or_addresses'] as $or_address)
                {
                    preg_match('/^\[?([0-9a-f:.]*)]?:\d+$/', $or_address, $or_address_matches);
                    if (count($or_address_matches) === 2)
                    {
                        $onion_relay->IPAddress = $or_address_matches[1];
                    }
                }

                if (filter_var($onion_relay->IPAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
                    $onion_relay->IPVersion = 4;
                if (filter_var($onion_relay->IPAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
                   $onion_relay->IPVersion = 6;

                if(isset($relay['nickname']))
                    $onion_relay->Nickname = $relay['nickname'];

                if(isset($relay['fingerprint']))
                    $onion_relay->Fingerprint = $relay['fingerprint'];

                if(isset($relay['or_addresses']))
                {
                    $onion_relay->OrAddresses = $relay['or_addresses'];
                }
                else
                {
                    $onion_relay->OrAddresses = [];
                }

                if(isset($relay['exit_addresses']))
                {
                    $onion_relay->ExitAddresses = $relay['exit_addresses'];
                }
                else
                {
                    $onion_relay->ExitAddresses = [];
                }

                if(isset($relay['dir_address']))
                {
                    $parsed = explode(':', $relay['dir_address']);
                    $onion_relay->DirAddress = $parsed[0];
                    $onion_relay->DirPort = (int)$parsed[1];
                }

                if(isset($relay['last_seen']))
                    $onion_relay->LastSeenTimestamp = strtotime($relay['last_seen']);

                if(isset($relay['last_changed_address_or_port']))
                    $onion_relay->LastChangedAddressOrPort = strtotime($relay['last_changed_address_or_port']);

                if(isset($relay['first_seen']))
                    $onion_relay->FirstSeen = strtotime($relay['first_seen']);

                if(isset($relay['running']))
                    $onion_relay->Running = (bool)$relay['running'];

                if(isset($relay['flags']))
                {
                    $onion_relay->Flags = $relay['flags'];

                    $onion_relay->Exit = in_array('Exit', $relay['flags']);
                    $onion_relay->Fast = in_array('Fast', $relay['flags']);
                    $onion_relay->Guard = in_array('Guard', $relay['flags']);
                    $onion_relay->Stable = in_array('Stable', $relay['flags']);
                    $onion_relay->Valid = in_array('Valid', $relay['flags']);
                }

                /** @noinspection DuplicatedCode */
                if(isset($relay['contact']))
                    $onion_relay->Contact = $relay['contact'];

                if(isset($relay['platform']))
                    $onion_relay->Platform = $relay['platform'];

                if(isset($relay['version']))
                    $onion_relay->Version = $relay['version'];

                if(isset($relay['version_status']))
                    $onion_relay->VersionStatus = $relay['version_status'];

                if(isset($relay['consensus_weight']))
                    $onion_relay->ConsensusWeight = $relay['consensus_weight'];

                $onion_relay->LastUpdatedTimestmap = time();
                $onion_relay->CreatedTimestmap = time();

                $secondary_addresses = [];

                if(isset($relay['or_addresses']) && count($relay['or_addresses']) > 0)
                {
                    foreach($relay['or_addresses'] as $address)
                    {
                        $first_address = explode(':', $address)[0];
                        if(in_array($first_address, $secondary_addresses) == false)
                        {
                            if (filter_var($first_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
                            {
                                $second_onion_relay = $onion_relay;
                                $second_onion_relay->IPAddress = $first_address;
                                $second_onion_relay->IPVersion = 4;
                                $results[] = $second_onion_relay;
                                $secondary_addresses[] = $first_address;
                            }
                            elseif (filter_var($first_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
                            {
                                $second_onion_relay = $onion_relay;
                                $second_onion_relay->IPAddress = $first_address;
                                $second_onion_relay->IPVersion = 6;
                                $results[] = $second_onion_relay;
                                $secondary_addresses[] = $first_address;
                            }
                        }
                    }
                }

                if(isset($relay['exit_addresses']) && count($relay['exit_addresses']) > 0)
                {
                    foreach($relay['exit_addresses'] as $address)
                    {
                        $first_address = explode(':', $address)[0];
                        if(in_array($first_address, $secondary_addresses) == false)
                        {
                            if (filter_var($first_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4))
                            {
                                $second_onion_relay = $onion_relay;
                                $second_onion_relay->IPAddress = $first_address;
                                $second_onion_relay->IPVersion = 4;
                                $results[] = $second_onion_relay;
                                $secondary_addresses[] = $first_address;
                            }
                            elseif (filter_var($first_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6))
                            {
                                $second_onion_relay = $onion_relay;
                                $second_onion_relay->IPAddress = $first_address;
                                $second_onion_relay->IPVersion = 6;
                                $results[] = $second_onion_relay;
                                $secondary_addresses[] = $first_address;
                            }
                        }

                    }
                }

                $results[] = $onion_relay;
            }

            return $results;
        }
    }