/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.esprit.workshop.tests;

import java.io.IOException;

import animatefx.animation.FadeInDown;
import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.stage.Stage;

/**
 *
 * @author FGH
 */
public class NewFXMain extends Application {

    @Override
    public void start(Stage primaryStage) {

        try {

            FXMLLoader loader = new FXMLLoader(getClass().getResource("../gui/adds.fxml"));
            Parent root = loader.load();


            Scene scene = new Scene(root, 800, 500);

            primaryStage.setTitle("Projet X");
            primaryStage.setScene(scene);
            primaryStage.show();
            new FadeInDown(root).play();

        } catch (IOException ex) {
            System.err.println(ex.getMessage());
        }

    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        launch(args);
    }

}
