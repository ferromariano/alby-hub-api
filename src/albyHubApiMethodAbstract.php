<?php

namespace AlbyHubApi;

abstract class albyHubApiMethodAbstract extends albyHubApiAbstract
{
    /** PUBLIC METHODS **/

    /**
     * Starts the node and returns a JWT token.
     *
     * @param string $unlockPassword The password to unlock the node.
     * @return array Contains the token and other node startup information.
     */
    public function start(string $unlockPassword): array {
        return $this->request('POST', '/api/start', ['unlockPassword' => $unlockPassword]);
    }

    public function getInfo(): array {
        return $this->request('GET', '/api/info');
    }

    public function getBalances(): array {
        return $this->request('GET', '/api/balances');
    }

    public function listChannels(): array {
        return $this->request('GET', '/api/channels');
    }

    public function listPeers(): array {
        return $this->request('GET', '/api/peers');
    }

    public function getNodeStatus(): array {
        return $this->request('GET', '/api/node/status');
    }

    public function getNodeConnectionInfo(): array {
        return $this->request('GET', '/api/node/connection-info');
    }

    public function getAutoSwapsConfig(): array {
        return $this->request('GET', '/api/settings/swaps');
    }

    public function disableAutoSwaps(): void {
        $this->request('DELETE', '/api/settings/swaps');
    }

    public function enableAutoSwaps(array $config): void {
        $this->request('POST', '/api/settings/swaps', $config);
    }

    public function getCustomNodeCommands(): array {
        return $this->request('GET', '/api/commands');
    }

    public function executeCustomNodeCommand(string $command): array {
        return $this->request('POST', '/api/command', ['command' => $command]);
    }

    public function stop(): void {
        $this->request('POST', '/api/stop');
    }

    public function resetRouter(string $key): void {
        $this->request('POST', '/api/reset-router', ['key' => $key]);
    }

    public function signMessage(string $message): array {
        return $this->request('POST', '/api/wallet/sign-message', ['message' => $message]);
    }

    public function syncWallet(): void {
        $this->request('POST', '/api/wallet/sync');
    }

    public function redeemOnchainFunds(array $data): array {
        return $this->request('POST', '/api/wallet/redeem-onchain-funds', $data);
    }

    public function makeOffer(string $description): string {
        return $this->request('POST', '/api/offers', ['description' => $description]);
    }

    public function makeInvoice(int $amount, string $description): array {
        return $this->request('POST', '/api/invoices', ['amount' => $amount, 'description' => $description]);
    }

    /**
     * Sends a payment using a Bolt11 invoice.
     *
     * @param string $invoice The invoice string to pay.
     * @param int $amount Amount in sats (optional if not in invoice).
     * @param array|null $metadata Optional metadata for tracking or tagging.
     * @return array Payment response.
     */
    public function sendPayment(string $invoice, int $amount, ?array $metadata = null): array {
        return $this->request('POST', "/api/payments/$invoice", [
            'amount' => $amount,
            'metadata' => $metadata,
        ]);
    }

    public function getWalletCapabilities(): array {
        return $this->request('GET', '/api/wallet/capabilities');
    }

    public function createApp(array $data): array {
        return $this->request('POST', '/api/apps', $data);
    }

    public function listApps(): array {
        return $this->request('GET', '/api/apps');
    }

    public function getApp(string $pubkey): array {
        return $this->request('GET', "/api/apps/$pubkey");
    }

    /**
     * Updates an app's configuration.
     *
     * @param string $pubkey Public key of the app.
     * @param array $data The new configuration parameters.
     */
    public function updateApp(string $pubkey, array $data): void {
        $this->request('PATCH', "/api/apps/$pubkey", $data);
    }

    public function deleteApp(string $pubkey): void {
        $this->request('DELETE', "/api/apps/$pubkey");
    }

    public function topupApp(string $pubkey, int $amount): void {
        $this->request('POST', "/api/apps/$pubkey/topup", ['amount' => $amount]);
    }

    public function getMnemonic(string $unlockPassword): array {
        return $this->request('POST', '/api/mnemonic', ['unlockPassword' => $unlockPassword]);
    }

    public function backup(): array {
        return $this->request('POST', '/api/backup');
    }

    public function restoreBackup(array $data): void {
        $this->request('POST', '/api/restore', $data);
    }

    public function setup(array $data): void {
        $this->request('POST', '/api/setup', $data);
    }

    public function unlock(string $unlockPassword, ?int $tokenExpiryDays = null): array {
        return $this->request('POST', '/api/unlock', [
            'unlockPassword' => $unlockPassword,
            'tokenExpiryDays' => $tokenExpiryDays
        ]);
    }

    /**
     * Changes the unlock password of the node.
     *
     * @param string $current Current unlock password.
     * @param string $new New unlock password.
     */
    public function changeUnlockPassword(string $current, string $new): void {
        $this->request('PATCH', '/api/unlock-password', [
            'currentUnlockPassword' => $current,
            'newUnlockPassword' => $new
        ]);
    }

    public function setAutoUnlockPassword(string $unlockPassword): void {
        $this->request('PATCH', '/api/auto-unlock', [
            'unlockPassword' => $unlockPassword
        ]);
    }

    public function setCurrency(string $currency): void {
        $this->request('PATCH', '/api/settings', ['currency' => $currency]);
    }

    public function setNodeAlias(string $alias): void {
        $this->request('POST', '/api/node/alias', ['nodeAlias' => $alias]);
    }

    public function getLogOutput(string $type, int $maxLen = 2000): array {
        return $this->request('GET', "/api/log/$type?maxLen=$maxLen");
    }

    public function getTransactions(int $limit = 20, int $offset = 0, ?int $appId = null): array {
        $query = http_build_query(['limit' => $limit, 'offset' => $offset, 'appId' => $appId]);
        return $this->request('GET', "/api/transactions?$query");
    }

    public function getTransactionByHash(string $paymentHash): array {
        return $this->request('GET', "/api/transactions/$paymentHash");
    }

    public function getNewOnchainAddress(): array {
        return $this->request('POST', '/api/wallet/new-address');
    }

    public function getUnusedOnchainAddress(): array {
        return $this->request('GET', '/api/wallet/address');
    }

    public function getOnchainTransactions(): array {
        return $this->request('GET', '/api/node/transactions');
    }

    public function getHealth(): array {
        return $this->request('GET', '/api/health');
    }

    public function sendPaymentProbes(string $invoice): array {
        return $this->request('POST', '/api/send-payment-probes', ['invoice' => $invoice]);
    }

    public function sendSpontaneousPaymentProbes(string $nodeId, int $amount): array {
        return $this->request('POST', '/api/send-spontaneous-payment-probes', ['nodeId' => $nodeId, 'amount' => $amount]);
    }

    public function getNetworkGraph(array $nodeIds = []): array {
        $query = http_build_query(['nodeIds' => implode(',', $nodeIds)]);
        return $this->request('GET', "/api/node/network-graph?$query");
    }

    public function migrateNodeStorage(string $to): void {
        $this->request('POST', '/api/node/migrate-storage', ['to' => $to]);
    }

    public function event(string $event): void {
        $this->request('POST', '/api/event', ['event' => $event]);
    }

    public function backupReminder(string $nextReminder): void {
        $this->request('PATCH', '/api/backup-reminder', ['nextBackupReminder' => $nextReminder]);
    }

    public function channelSuggestions(): array {
        return $this->request('GET', '/api/channels/suggestions');
    }

    /**
     * Connects to a new peer.
     *
     * @param array $data Contains keys like 'nodeId' and 'host'.
     */
    public function connectPeer(array $data): void {
        $this->request('POST', '/api/peers', $data);
    }

    public function disconnectPeer(string $peerId): void {
        $this->request('DELETE', "/api/peers/$peerId");
    }

    public function openChannel(array $data): array {
        return $this->request('POST', '/api/channels', $data);
    }

    public function closeChannel(string $peerId, string $channelId, bool $force = false): array {
        return $this->request('DELETE', "/api/peers/$peerId/channels/$channelId?force=" . ($force ? 'true' : 'false'));
    }

    public function updateChannel(string $peerId, string $channelId, array $data): void {
        $this->request('PATCH', "/api/peers/$peerId/channels/$channelId", $data);
    }

    public function mempool(string $endpoint): array {
        return $this->request('GET', "/api/mempool?endpoint=" . urlencode($endpoint));
    }
}