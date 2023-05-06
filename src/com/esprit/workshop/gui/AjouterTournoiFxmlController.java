package com.esprit.workshop.gui;
import com.esprit.workshop.entites.Gamer;
import com.esprit.workshop.entites.Tournoi;
import com.esprit.workshop.entites.classement;
import com.esprit.workshop.services.ServiceTournoi;
import com.esprit.workshop.services.serviceclassement;
import javafx.beans.property.SimpleStringProperty;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.*;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import org.apache.poi.ss.usermodel.*;
import org.apache.poi.util.IOUtils;
import org.apache.poi.xssf.usermodel.XSSFWorkbook;

import java.io.*;
import java.net.URL;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.sql.SQLException;
import java.util.List;
import java.util.ResourceBundle;
import java.util.UUID;

/**
 * FXML Controller class
 *
 * @author FGH
 */
public class AjouterTournoiFxmlController implements Initializable {
    public Button exportButton;
    @FXML
    private TextField tfnbteam;
    @FXML
    private TextField importer;
    @FXML
    private TextField tfnbjoueur;
    @FXML
    private TextField tfnomtournoi;
    @FXML
    private TextField tfdevice;
    @FXML
    private TextField recherche;
    @FXML
    private TableColumn<Tournoi, String> ndevice;

    @FXML
    void find(MouseEvent event) {

    }

    @FXML
    private TableColumn<Tournoi, Integer> nequipe;

    @FXML
    private Button back;
    @FXML
    private ImageView affichertournoi;

    @FXML
    private TableColumn<Tournoi, Integer> njoueur;

    @FXML
    private TableColumn<Tournoi, String> ntournoi;

    @FXML
    private TableView<Tournoi> table_tournoi;
    @FXML
    private Button btnAjouter;

    @FXML
    private ImageView upload;
    public ObservableList<Tournoi> data = FXCollections.observableArrayList();
    public ObservableList<classement> data1 = FXCollections.observableArrayList();
    private File selectedImageFile;
    private String imageName;

    @FXML
    private TableColumn<classement,String> cnomteam;

    @FXML
    private TableColumn<classement, Integer> cscore;
    @FXML
    private TableView<classement> classments;
    Gamer g=new Gamer();

    /**
     * Initializes the controller class.
     */

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        g.setId(2);
        showtournoi();
        table_tournoi.setOnMouseClicked(event -> {
            if (event.getClickCount() == 1) { // vérifie que l'utilisateur a cliqué une fois
                Tournoi tournoiSelectionne = table_tournoi.getSelectionModel().getSelectedItem(); // récupère l'objet Groupe sélectionné dans le TableView


                if (tournoiSelectionne != null) {

                    int idTournoiSelectionne = tournoiSelectionne.getId();
                    try {
                        List<classement> list = new serviceclassement().selectAll(idTournoiSelectionne);
                        data1.setAll(list);
                    } catch (SQLException ex) {
                        System.err.println(ex.getMessage());
                    }
                    cscore.setCellValueFactory(new PropertyValueFactory<classement, Integer>("score"));
                    cnomteam.setCellValueFactory(cellData -> new SimpleStringProperty(cellData.getValue().getTeam().getNom_team()));

                    classments.setItems(data1);

                    tfdevice.setText(tournoiSelectionne.getDevice()); // affiche le nom du groupe dans un TextField
                    //System.out.println(groupeSelectionne.getImage());

                    tfnomtournoi.setText(tournoiSelectionne.getNomtournoi());
                    tfnbteam.setText(String.valueOf(tournoiSelectionne.getNb_team()));
                    importer.setText(tournoiSelectionne.getImage());

                    tfnbjoueur.setText(String.valueOf(tournoiSelectionne.getNb_joueur_team()));

                    try {
                        Image img = new Image("C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/uploadtournoi/" + tournoiSelectionne.getImage());
                        System.out.println(tournoiSelectionne.getImage());
                        affichertournoi.setImage(img);
                    } catch (Exception e) {
                        System.out.println("Error loading image: " + e.getMessage());
                    }


                }
            }
        });
    }
    @FXML
    private void exportToExcel(ActionEvent event) {
        // Create a new workbook
        Workbook workbook = new XSSFWorkbook();

        // Create a new sheet
        Sheet sheet = workbook.createSheet("Table Data");

        // Add logo image to first row, first column
        try {
            InputStream logoStream = new FileInputStream("C:\\Users\\bayou\\Desktop\\Nouveau dossier (2)\\kamell.png");
            byte[] logoBytes = IOUtils.toByteArray(logoStream);
            int logoIndex = workbook.addPicture(logoBytes, Workbook.PICTURE_TYPE_PNG);
            logoStream.close();

            CreationHelper helper = workbook.getCreationHelper();
            Drawing drawing = sheet.createDrawingPatriarch();
            ClientAnchor anchor = helper.createClientAnchor();
            anchor.setCol1(0);
            anchor.setRow1(0);
            anchor.setCol2(1); // span two columns for the logo image
            anchor.setRow2(1); // span two rows for the logo image
            drawing.createPicture(anchor, logoIndex);
        } catch (IOException e) {
            System.err.println("Error adding logo image to sheet: " + e.getMessage());
        }

        // Set width of first column
        sheet.setColumnWidth(800, 8000);

        // Create a purple background color style
        CellStyle purpleStyle = workbook.createCellStyle();
        purpleStyle.setFillForegroundColor(IndexedColors.PLUM.getIndex());
        purpleStyle.setFillPattern(FillPatternType.SOLID_FOREGROUND);

        // Create header row
        Row headerRow = sheet.createRow(2);
        headerRow.createCell(0).setCellValue("nom equipe");
        headerRow.createCell(1).setCellValue("score");
        // Set header row style
        headerRow.getCell(0).setCellStyle(purpleStyle);
        headerRow.getCell(1).setCellStyle(purpleStyle);

        // Populate data rows
        int rowIndex = 3;
        for (classement data : classments.getItems()) {
            Row dataRow = sheet.createRow(rowIndex++);
            dataRow.createCell(0).setCellValue(data.getTeam().getNom_team());
            dataRow.createCell(1).setCellValue(data.getScore());
            // Set data row style
            dataRow.getCell(0).setCellStyle(purpleStyle);
            dataRow.getCell(1).setCellStyle(purpleStyle);
        }

        // Resize columns to fit content
        sheet.autoSizeColumn(0);
        sheet.autoSizeColumn(1);
        sheet.autoSizeColumn(2);

        // Save the workbook to a file
        try {
            FileOutputStream fileOut = new FileOutputStream("C:\\Users\\bayou\\Desktop\\Nouveau dossier (2)\\test_data.xlsx");
            workbook.write(fileOut);
            fileOut.close();
            System.out.println("Exported test data to C:\\Users\\bayou\\Desktop\\Nouveau dossier (2)\\test_data.xlsx");
        } catch (IOException e) {
            System.err.println("Error exporting table data to Excel: " + e.getMessage());
        }
    }






    @FXML
    private void AjouterTournoi(ActionEvent event) {
        if (tfnbteam.getText().isEmpty() || tfnbjoueur.getText().isEmpty() || tfnomtournoi.getText().isEmpty() || tfdevice.getText().isEmpty()|| importer.getText().isEmpty()) {
            Alert al = new Alert(Alert.AlertType.WARNING);
            al.setTitle("Erreur de donnee");
            al.setContentText("Veuillez verifier les données !");
            al.show();
        } else {
            String nbteamText = tfnbteam.getText();
            if (!nbteamText.matches("\\d+")) {
                Alert al = new Alert(Alert.AlertType.WARNING);
                al.setTitle("Erreur de donnée");
                al.setContentText("Le nombre d'équipes doit être un nombre entier !");
                al.show();
                return; // Return to prevent further processing
            }
            int nbteam = Integer.parseInt(nbteamText);

            String nbjoueurText = tfnbjoueur.getText();
            if (!nbjoueurText.matches("\\d+")) {
                Alert al = new Alert(Alert.AlertType.WARNING);
                al.setTitle("Erreur de donnée");
                al.setContentText("Le nombre de joueurs doit être un nombre entier !");
                al.show();
                return; // Return to prevent further processing
            }
            int nbjoueur = Integer.parseInt(nbjoueurText);

            if (nbteam <= 4) {
                Alert al = new Alert(Alert.AlertType.WARNING);
                al.setTitle("Erreur de donnée");
                al.setContentText("Le nombre d'équipes doit être supérieur à 4 !");
                al.show();
                return; // Return to prevent further processing
            } else if (nbjoueur <= 2) {
                Alert al = new Alert(Alert.AlertType.WARNING);
                al.setTitle("Erreur de donnée");
                al.setContentText("Le nombre de joueurs doit être supérieur à 2 !");
                al.show();
                return; // Return to prevent further processing
            }

            String tournamentName = tfnomtournoi.getText();
            if (tournamentName.length() < 5) {
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Erreur de donnée");
                alert.setContentText("Le nom du tournoi doit contenir au moins 5 caractères !");
                alert.show();
                return; // Return to prevent further processing
            } else if (!tournamentName.matches("[a-zA-Z\\s-]+")) {
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Erreur de donnée");
                alert.setContentText("Le nom du tournoi ne doit contenir que des lettres, des espaces et des tirets !");
                alert.show();
                return; // Return to prevent further processing
            }
            String deviceText = tfdevice.getText();
            if (deviceText.length() < 3 || !deviceText.matches("[a-zA-Z]+")) {
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Erreur de donnée");
                alert.setContentText("Le nom de l'appareil doit contenir au moins 3 caractères et uniquement des lettres !");
                alert.show();
                return;
            }
            Tournoi t = new Tournoi(Integer.parseInt(tfnbteam.getText()), Integer.parseInt(tfnbteam.getText()), tfnomtournoi.getText(), tfdevice.getText(), importer.getText());
            ServiceTournoi sp = new ServiceTournoi();

            try {
               int rowsInserted= sp.insertOne(t,g);
                if (rowsInserted > 0) {
                    Alert alert = new Alert(Alert.AlertType.INFORMATION);
                    alert.setTitle("Succès");
                    alert.setHeaderText("Tournoi ajouté");
                    alert.setContentText("Le tournoi a été ajouté avec succès !");
                    alert.showAndWait();
                } else {
                    Alert alert = new Alert(Alert.AlertType.WARNING);
                    alert.setTitle("Attention");
                    alert.setHeaderText("Tournoi existant");
                    alert.setContentText("Le tournoi existe déjà !");
                    alert.showAndWait();
                }
                resetForm();
                data.clear();
                showtournoi();
            } catch (SQLException ex) {
                Alert al = new Alert(Alert.AlertType.ERROR);
                al.setTitle("Erreur de donnee");
                al.setContentText(ex.getMessage());
                al.show();
            }
        }

    }

    public void showtournoi() {
        try {
            List<Tournoi> list = new ServiceTournoi().selectmine(g);
            String s = list.toString();
            data.addAll(list);
        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        ndevice.setCellValueFactory(new PropertyValueFactory<Tournoi, String>("device"));
        ntournoi.setCellValueFactory(new PropertyValueFactory<Tournoi, String>("nomtournoi"));
        nequipe.setCellValueFactory(new PropertyValueFactory<Tournoi, Integer>("nb_team"));
        njoueur.setCellValueFactory(new PropertyValueFactory<Tournoi, Integer>("nb_joueur_team"));
        table_tournoi.setItems(data);

    }

    public void searchtournoi(ActionEvent event) {
        int i = 0;
        try {
            List<Tournoi> list = new ServiceTournoi().select(recherche.getText());

            if (!list.isEmpty()) {
                Tournoi firstTournoi = list.get(0);
                tfnbteam.setText(Integer.toString(firstTournoi.getNb_team()));
                tfnbjoueur.setText(Integer.toString(firstTournoi.getNb_joueur_team()));
                tfnomtournoi.setText(firstTournoi.getNomtournoi());
                tfdevice.setText(firstTournoi.getDevice());
                importer.setText(firstTournoi.getImage());
                i = 1;
            }

        } catch (SQLException ex) {
            System.err.println(ex.getMessage());
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        if (i == 0) {
            Alert alert = new Alert(Alert.AlertType.ERROR, "Aucun tournoi ", ButtonType.OK);
            alert.showAndWait();
        }
    }

    public void edittournoi(ActionEvent event) {
        Tournoi tournoiSelectionne = table_tournoi.getSelectionModel().getSelectedItem();
        if (tournoiSelectionne == null) {
            Alert al = new Alert(Alert.AlertType.WARNING);
            al.setTitle("Erreur de données");
            al.setContentText("Veuillez sélectionner un tournoi !");
            al.show();
            return;
        }

        Tournoi t = new Tournoi(Integer.parseInt(tfnbteam.getText()), Integer.parseInt(tfnbjoueur.getText()), tfnomtournoi.getText(), tfdevice.getText(), importer.getText());
        ServiceTournoi sp = new ServiceTournoi();


        try {
           int rowsUpdated= sp.updateTournoi(t, tournoiSelectionne.getNomtournoi());
            if (rowsUpdated > 0) {
                Alert alert = new Alert(Alert.AlertType.INFORMATION);
                alert.setTitle("Succès");
                alert.setHeaderText("Tournoi modifié");
                alert.setContentText("Le tournoi a été modifié avec succès !");
                alert.showAndWait();
            } else {
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Attention");
                alert.setHeaderText("Aucun tournoi modifié");
                alert.setContentText("Aucun tournoi n'a été modifié !");
                alert.showAndWait();
            }
            resetForm();
            data.clear();
            showtournoi();
        } catch (SQLException ex) {
            Alert al = new Alert(Alert.AlertType.ERROR);
            al.setTitle("Erreur de données");
            al.setContentText(ex.getMessage());
            al.show();
        }

    }

    public void deletetournoi(ActionEvent event) {
        ServiceTournoi sp = new ServiceTournoi();
        Tournoi tournoiSelectionne = table_tournoi.getSelectionModel().getSelectedItem(); // récupère l'objet Groupe sélectionné dans le TableView
        if (tournoiSelectionne == null) {
            Alert al = new Alert(Alert.AlertType.WARNING);
            al.setTitle("Erreur de données");
            al.setContentText("Veuillez sélectionner un tournoi !");
            al.show();
            return;
        }

        try {
            int rowsDeleted=  sp.deleteTournoi(tournoiSelectionne);
            if (rowsDeleted > 0) {
                Alert alert = new Alert(Alert.AlertType.INFORMATION);
                alert.setTitle("Succès");
                alert.setHeaderText("Tournoi supprimé");
                alert.setContentText("Le tournoi a été supprimé avec succès !");
                alert.showAndWait();
            } else {
                Alert alert = new Alert(Alert.AlertType.WARNING);
                alert.setTitle("Attention");
                alert.setHeaderText("Aucun tournoi supprimé");
                alert.setContentText("Aucun tournoi n'a été supprimé !");
                alert.showAndWait();
            }
            resetForm();
            data.clear();
            showtournoi();
        } catch (SQLException ex) {
            Alert al = new Alert(Alert.AlertType.ERROR);
            al.setTitle("Erreur de donnee");
            al.setContentText(ex.getMessage());
            al.show();
            System.out.println(ex.getMessage());

        }
    }
    @FXML
    void uploadimage(MouseEvent event) throws IOException {
        FileChooser fileChooser = new FileChooser();
        fileChooser.setTitle("Choisir une image");
        fileChooser.getExtensionFilters().addAll(new FileChooser.ExtensionFilter("Image Files", "*.png", "*.jpg", "*.jpeg", "*.gif"));
        selectedImageFile = fileChooser.showOpenDialog(upload.getScene().getWindow());
        if (selectedImageFile != null) {
            Image image = new Image(selectedImageFile.toURI().toString());
            upload.setImage(image);

            // Générer un nom de fichier unique pour l'image
            String uniqueID = UUID.randomUUID().toString();
            String extension = selectedImageFile.getName().substring(selectedImageFile.getName().lastIndexOf(".")); // Récupérer
            // l'extension
            // de
            // l'image
            imageName = uniqueID + extension;

            // Enregistrer l'image dans le dossier "uploads"
            // Path destination = Paths.get("D:/SSD
            // SUPORT/Desktop/pidev_java/zeroWaste-javaFX/src/assets/ProductUploads/" +
            // imageName);
            Path destination = Paths.get("C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/uploadtournoi/" + imageName);

            Files.copy(selectedImageFile.toPath(), destination, StandardCopyOption.REPLACE_EXISTING);
            importer.setText(imageName);
            // pour le controle de
            /*
            photoTest = 1;
            photoInputErrorHbox.setVisible(false);
             */
        }
    }
    private void resetForm() {
        tfnbteam.clear();
        tfnbjoueur.clear();
        tfnomtournoi.clear();
        tfdevice.clear();
        importer.clear();
        affichertournoi.setImage(null);

        Image newImage = new Image("file:C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/assets/download.png");
        upload.setImage(newImage);


        // Reset image view
      //
        /*up = new Image("C:/Users/bayou/Desktop/WorkshopJDBC3A37/src/com/esprit/workshop/assets/download.png");
        affichertournoi.setImage(upload);
        upload.setImage(imgUpload);*/

    }
    public void btnretour(ActionEvent event) throws IOException {
        Parent root = FXMLLoader.load(getClass().getResource("adds.fxml"));

        Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
        Scene scene = new Scene(root);
        stage.setScene(scene);
        stage.show();

    }

    public void clears(ActionEvent event) {
        resetForm();
    }
}
