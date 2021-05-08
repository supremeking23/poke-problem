<?php foreach($users_to_poke as $users):?>
                        <tr>
                            <th scope="row"><?= $users["name"]?></th>
                            <td><?= $users["alias"]?></td>
                            <td><?= $users["email"]?></td>
                            <td><?= $users["poke_history"]?></td>
                            <td>
<!-- "pokes/poke_process" -->
<?= form_open("pokes/poke_process_ajax");?>
                                    <input type="hidden" name="poke_from" value="<?= $this->session->userdata("user_id");?>">
                                    <input type="hidden" name="poke_to" value="<?= $users["id"];?>">
                                    <button type="submit">Poke</button>
                                </form>
                            </td>
                        </tr>
<?php endforeach; ?> 