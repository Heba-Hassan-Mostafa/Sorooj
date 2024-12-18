<?php

namespace App\Http\Controllers\Api\V1\Chat;

use App\Actions\Chats\GetChatAction;
use App\Actions\Chats\GetChatsAction;
use App\Actions\Chats\SendMessageAction;
use App\Enum\Chat\ChatUsersTypeEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\Chat\GetChatRequest;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Http\Resources\Api\Chat\ChatResource;
use App\Http\Resources\Api\Chat\MessageResource;
use App\Models\Chat;
use App\Models\Order;
use App\Repositories\Contracts\ChatContract;
use App\Traits\ApiResponseTrait;

/**
 * @group chat
 *
 * @subgroup Chat
 * @subgroupDescription Chat Apis
 */
class ChatController extends BaseApiController
{
    use ApiResponseTrait;

    protected mixed $modelResource = ChatResource::class;

    public function __construct(ChatContract $repository)
    {
        parent::__construct($repository, ChatResource::class);
    }

    /**
     * List Chats
     *
     * an API which Offers a mean to list Chats
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    public function index(): mixed
    {
        $chats = (new GetChatsAction())->handle(auth(activeGuard())->user());
        return $this->respondWithCollection(ChatResource::collection($chats));
    }

    /**
     * show chat
     *
     * an API which Offers a mean to show chat
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    protected function showChat(GetChatRequest $request)
    {
        $order = Order::findOrFail($request->order_id);
        $chat = (new GetChatAction())->handle($order, auth()->user(), $request->type);

        return $this->respondWithModel($chat);
    }

    /**
     * send message
     *
     * an API which Offers a mean to send message
     * @authenticated
     * @header Api-Key xx
     * @header Api-Version v1
     * @header Accept-Language ar
     */
    protected function sendMessage(SendMessageRequest $request, Chat $chat)
    {
        $to = ChatUsersTypeEnum::model($request->to_type);
        $to = $to::findOrFail((int) $request->to_id);

        $message = (new SendMessageAction())
            ->handle($chat, auth()->user(), $to, $request->message, [], toType: $request->to_type);

        return $this->setStatusCode(200)->respond(new MessageResource($message), []);

    }
}
