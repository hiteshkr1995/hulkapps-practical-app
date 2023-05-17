To integrate Paytm payment gateway into an Android app without the need for a backend server, you can use the Paytm All-In-One SDK. Here's how you can do it:

Step 1: Add Paytm SDK dependency

1. Add the Paytm SDK dependency to your app's `build.gradle` file:

```kotlin
dependencies {
    implementation 'com.paytm.appinvokesdk:appinvokesdk:2.8.5'
}
```

2. Sync your project to download the SDK.

Step 2: Initialize Paytm

1. In your activity or fragment, import the necessary classes:

```kotlin
import com.paytm.appinvokesdk.PaytmError
import com.paytm.appinvokesdk.callbacks.TransactionCallback
import com.paytm.appinvokesdk.models.InitiateTransactionRequestBody
import com.paytm.appinvokesdk.models.InitiateTransactionResponseBody
import com.paytm.appinvokesdk.models.TransactionInfo
import com.paytm.appinvokesdk.models.TransactionStatus
import com.paytm.appinvokesdk.models.UserInfo
import com.paytm.appinvokesdk.models.UserType
```

2. Create a `UserInfo` object to specify the user details:

```kotlin
val userInfo = UserInfo("USER_ID", "USER_NAME", UserType.CUSTOMER)
```

3. Create an `InitiateTransactionRequestBody` object to specify the transaction details:

```kotlin
val requestBody = InitiateTransactionRequestBody(
    orderId = "ORDER_ID",
    txnAmount = "10.00",
    userInfo = userInfo
)
```

Replace `"ORDER_ID"` with your actual order ID and `"10.00"` with the transaction amount.

4. Initialize the Paytm SDK and start the payment transaction:

```kotlin
PaytmSDK.initiateTransaction(context, requestBody, object : TransactionCallback {
    override fun onTransactionInitiated(responseBody: InitiateTransactionResponseBody) {
        // Transaction initiated successfully
        val transactionInfo = TransactionInfo(
            orderId = responseBody.orderId,
            transactionToken = responseBody.transactionToken
        )
        PaytmSDK.startTransaction(context, transactionInfo)
    }

    override fun onError(error: PaytmError) {
        // Transaction initialization failed
    }

    override fun onTransactionStatus(status: TransactionStatus) {
        // Handle transaction status updates
    }
})
```

5. Handle the transaction status updates in the `onTransactionStatus()` method.

That's it! You have now integrated Paytm payment gateway into your Android app without the need for a backend server. Test your app thoroughly, and when you're ready to accept real payments, replace the `USER_ID` and `USER_NAME` with your actual user details, and replace the `ORDER_ID` and transaction amount with actual values.
