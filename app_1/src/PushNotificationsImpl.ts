
import {
  Plugins,
  PushNotification,
  PushNotificationToken,
  PushNotificationActionPerformed } from '@capacitor/core';
import axios from 'axios';
import utils from '@/utils';

const { PushNotifications } = Plugins;

export default class PushNotificationsImpl {

  public static notification(id: any): void {
    console.log('Initializing pushnotifications');

    PushNotifications.register();

    PushNotifications.addListener('registration', 
      (token: PushNotificationToken) => {
        console.log('Push registration success, token: ' + token.value);
        const fcmpayload = {
        id: id,
        fcm_token: token.value,
        }
        axios.post(utils.apiUrl(`admin/fcm`), fcmpayload)
        .then((response) => {
        console.log("Pushing the fcm token to DB");
        console.log(response);
        })
        .catch((error) => {
        console.log(error);
        })
        .finally(() => {
        console.log("done");
        });
      }
    );

    PushNotifications.addListener('registrationError', 
      (error: any) => {
        console.log('Error on registration: ' + JSON.stringify(error));
      }
    );

    PushNotifications.addListener('pushNotificationReceived', 
      (notification: PushNotification) => {
        console.log('Push received: ' + JSON.stringify(notification));
      }
    );

    PushNotifications.addListener('pushNotificationActionPerformed', 
      (notification: PushNotificationActionPerformed) => {
        console.log('Push action performed: ' + JSON.stringify(notification));
      }
    );
}

}

